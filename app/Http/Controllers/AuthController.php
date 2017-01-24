<?php namespace App\Http\Controllers;

use App\API\API;

use App\API\Connectors\APIUser;
use App\API\Connectors\APIConfig;
use App\API\Connectors\APISendMail;

use Input, Session, Redirect, Socialite, Validator, Carbon, BalinMail;

use Illuminate\Support\MessageBag as MessageBag;

/**
 * Used for Auth Controller
 * 
 * @author agil
 */
class AuthController extends BaseController 
{
	protected $controller_name 						= 'Login';

	public function __construct()
	{
		parent::__construct();

		$this->page_attributes->title 				= 'BALIN.ID';
	}

	/**
	 * function to sign up new customer
	 *
	 * @param array of user profile
	 */
	public function postSignUp($id = "")
	{
		$type 							= 'login';
		if (preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]))
		{
			$dob						= Carbon::createFromFormat('d-m-Y', Input::get('dob'))->format('Y-m-d H:i:s');
		}
		else
		{
			$dob						= Carbon::createFromFormat('d-m-Y', Input::get('dob'))->format('Y-m-d H:i:s');
		}
		
		$data 							=	[
												'id'			=> $id,
												'name' 			=> Input::get('name'),
												'email'			=> Input::get('email'),
												'password'		=> Input::get('password'),
												'date_of_birth'	=> $dob,
												'gender'		=> Input::get('gender'),
												'role'			=> 'customer'
											];
		dd($data);
		
		if (Input::has('password') || is_null($id))
		{
			$validator 					= Validator::make(Input::only('password'), ['password' => 'required|min:8']);

			if (!$validator->passes())
			{
				$this->errors			= $validator->errors();
		
				return $this->generateRedirectRoute('balin.get.login', ['type' => 'signup']);
			}
		}

		Session::set('API_token', Session::get('API_token_public'));

		// API User
		$API_user 						= new APIUser;
		$user							= $API_user->postDataSignUp($data);

		if ($user['status'] != 'success')
		{
			$this->errors 				= $user['message'];
			$type 						= 'signup';
		}

		$this->page_attributes->success 			= "Terima kasih sudah mendaftar, Balin telah mengirimkan hadiah selamat datang untuk Anda melalui email Anda.";

		return $this->generateRedirectRoute('balin.get.login', ['type' => $type]);
	}

	/**
	 * function to sign in using facebook sso
	 *
	 * @return redirect driver sso
	 */
	public function getSso()
	{ 
		return Socialite::driver('facebook')->redirect();
	}

	/**
	 * function to retrieve data using facebook sso
	 *
	 * @param array of user sso data
	 */
	public function redirectSso()
	{ 
		$sso 								= (array)Socialite::driver('facebook')->user();

		$api_url 							= '/oauth/access_token';

		if(Session::has('invitation'))
		{
			$sso['reference_code']			= Session::get('invitation')['code'];
			$sso['invitation_link']			= Session::get('invitation')['link'];
		
			Session::forget('invitation');
		}

		$api_data 						= 	[
												'email' 			=> $sso['email'],
												'password' 			=> 'facebook',
												'sso' 				=> $sso,
												'grant_type'		=> 'password',
												'client_id'			=> env('CLIENT_ID'),
												'client_secret'		=> env('CLIENT_SECRET'),
											];

		$api 								= new API;
		$result 							= json_decode($api->post($api_url, $api_data), true);

		if ($result['status'] == "success")
		{
			//check registered user

			Session::put('API_token_private', $result['data']['token']['token']);
			Session::put('whoami', $result['data']['me']);
			Session::set('API_token', Session::get('API_token_private'));	
			Session::set('API_expired_token', Carbon::parse('+ 115 minutes')->format('Y-m-d H:i:s'));

			if (!Session::has('carts'))
			{
				$API_me 								= new APIUser;
				$me_order_in_cart 						= $API_me->getMeOrderInCart([
																'user_id' 	=> Session::get('whoami')['id'],
															]);
				if ($me_order_in_cart['status'] == 'success')
				{
					$carts 									= $me_order_in_cart;
					$temp_carts 							= [];

					foreach ($carts['data']['transactiondetails'] as $k => $v)
					{
						$temp_carts[$v['varian']['product_id']]		= 	[
								'product_id'		=> $v['varian']['product_id'],
								'slug'				=> $v['varian']['product']['slug'],
								'name'				=> $v['varian']['product']['name'],
								'discount'			=> $v['discount'],
								'current_stock'		=> $v['varian']['current_stock'],
								'thumbnail'			=> $v['varian']['product']['thumbnail'],
								'price'				=> $v['price'],
						];

						$temp_varian 	=	[
								'varian_id'			=> $v['varian_id'],
								'sku'				=> $v['varian']['sku'],
								'quantity'			=> $v['quantity'],
								'size'				=> $v['varian']['size'],
								'current_stock'		=> $v['varian']['current_stock'],
								'message'			=> null,
						];

						$temp_carts[$v['varian']['product_id']]['varians'][$v['varian']['id']]	= $temp_varian;
					}
					
					Session::set('carts', $temp_carts);
				}
			}
			else
			{
				/* SET API TOKEN USE TOKEN PRIVATE */
				$temp_carts 			= 	[
											'id'					=> '',
											'user_id'				=> Session::get('whoami')['id'],
											'transact_at'			=> date('Y-m-d H:i:s'),
											'transactiondetails'	=> [],
											'transactionlogs'		=> 	[
																			'id'		=> '',
																			'status'	=> 'cart',
																			'change_at'	=> '',
																			'notes'		=> ''
																		],
											'payment'				=> [],
											'shipment'				=> []
										];

				$session_cart 			= Session::get('carts');

				foreach($session_cart as $k => $v)
				{
					foreach($v['varians'] as $k2 => $v2)
					{
						$temp_varian[] 		= 	[
													'id' 				=> '',
													'transaction_id'	=> '',
													'quantity' 			=> $v2['quantity'],
													'price'				=> $v['price'],
													'discount'			=> $v['discount'],
													'varian_id'			=> $v2['varian_id'],
													'varians'			=> [
														'id'				=> $v2['varian_id'],
														'product_id'		=> $k,
														'sku'				=> $v2['sku'],
														'size'				=> $v2['size'],
													]
												];
						
					}
				}
				$temp_carts['transactiondetails']	= $temp_varian;
				$temp_carts['status']				= 'cart';


				$API_order 							= new APIUser;
				$result 							= $API_order->postMeOrder($temp_carts);

				// result
				if (isset($result['message']))
				{
					$this->error 					= $result['message'];
					return Redirect::route('balin.login.index', ['type' => 'login'])
							->withErrors($this->error)
							->with('msg-type', 'danger');
				}
			}

			if(Session::has('redirect_url'))
			{
				$redirect 							= Session::get('redirect_url');
				Session::forget('redirect_url');
				return Redirect::to($redirect);
			}
			
			return Redirect::route('my.balin.redeem.index');
		}
		else
		{
			return Redirect::route('balin.get.login', ['type' => 'signup'])
							->withErrors(['Maaf email yang ada pada facebook anda sudah terdaftar.'])
							->with('msg-type', 'danger');
		}
	}

	/**
	 * function to get login page
	 *
	 * @return view
	 */
	public function getLogin()
	{	
		if (Session::has('whoami'))
		{
			return Redirect::route('my.balin.redeem.index');
		}
		
		$breadcrumb										= ['Sign In' => route('balin.get.login')];

		$this->page_attributes->subtitle 			= 'Sign In';
		$this->page_attributes->controller_name		= $this->controller_name;
		$this->page_attributes->breadcrumb			= $breadcrumb;
		$this->page_attributes->type_form			= 'login';
		$this->page_attributes->source 				= 'login.index';

		return $this->generateView();
	}

	/**
	 * function to post login information
	 *
	 * @param email and password
	 */
	public function postLogin()
	{ 
		//check user data login
		$api_url 							= '/oauth/access_token';
		$api_data 							= 	[
													'email' 		=> Input::get('email'),
													'password' 		=> Input::get('password'),
													'grant_type'	=> 'password',
													'client_id'		=> env('CLIENT_ID'),
													'client_secret'	=> env('CLIENT_SECRET'),
												];

		$validator 							= 	[
													'email' 	=> 'required|email',
													'password'	=> 'required'
												];

		$validating 						= Validator::make($api_data, $validator);
		
		if($validating->passes())
		{
			$api 								= new API;
			$result 							= json_decode($api->post($api_url, $api_data), true);

			if ($result['status'] == "success")
			{
				$API_me 						= new APIUser;
				Session::put('API_token_private', $result['data']['token']['token']);
				Session::set('API_expired_token', Carbon::parse('+ 115 minutes')->format('Y-m-d H:i:s'));

				$whoami 						= $API_me->getMeDetail([
																	'user_id' 	=> $result['data']['me']['id'],
																	'token' 	=> Session::get('API_token_private'),
																]);
				Session::put('whoami', $whoami['data']);

				Session::put('API_token', Session::get('API_token_private'));	

				//check user before login carts
				if (!Session::has('carts'))
				{
					$me_order_in_cart 						= $API_me->getMeOrderInCart([
																	'user_id' 	=> Session::get('whoami')['id'],
																]);
					if ($me_order_in_cart['status'] == 'success')
					{
						$carts 									= $me_order_in_cart;
						$temp_carts 							= [];

						foreach ($carts['data']['transactiondetails'] as $k => $v)
						{
							$temp_carts[$v['varian']['product_id']]		= 	[
									'product_id'		=> $v['varian']['product_id'],
									'slug'				=> $v['varian']['product']['slug'],
									'name'				=> $v['varian']['product']['name'],
									'discount'			=> $v['discount'],
									'current_stock'		=> $v['varian']['current_stock'],
									'thumbnail'			=> $v['varian']['product']['thumbnail'],
									'price'				=> $v['price'],
							];

							$temp_varian 	=	[
									'varian_id'			=> $v['varian_id'],
									'sku'				=> $v['varian']['sku'],
									'quantity'			=> $v['quantity'],
									'size'				=> $v['varian']['size'],
									'current_stock'		=> $v['varian']['current_stock'],
									'message'			=> null,
							];

							$temp_carts[$v['varian']['product_id']]['varians'][$v['varian']['id']]	= $temp_varian;
						}

						Session::put('carts', $temp_carts);
					}
				}
				//check user no before login carts
				else
				{
					if (count(Session::get('carts')) != 0 )
					{
						/* SET API TOKEN USE TOKEN PRIVATE */
						$temp_carts 			= 	[
													'id'					=> '',
													'user_id'				=> Session::get('whoami')['id'],
													'transact_at'			=> date('Y-m-d H:i:s'),
													'transactiondetails'	=> [],
													'transactionlogs'		=> 	[
																					'id'		=> '',
																					'status'	=> 'cart',
																					'change_at'	=> '',
																					'notes'		=> ''
																				],
													'payment'				=> [],
													'shipment'				=> []
												];

						$session_cart 			= Session::get('carts');
						$temp_varian 			= [];

						foreach($session_cart as $k => $v)
						{
							foreach($v['varians'] as $k2 => $v2)
							{
								$temp_varian[] 		= 	[
															'id' 				=> '',
															'transaction_id'	=> '',
															'quantity' 			=> $v2['quantity'],
															'price'				=> $v['price'],
															'discount'			=> $v['discount'],
															'varian_id'			=> $v2['varian_id'],
															'varians'			=> [
																'id'				=> $v2['varian_id'],
																'product_id'		=> $k,
																'sku'				=> $v2['sku'],
																'size'				=> $v2['size'],
															]
														];
								
							}
						}
						$temp_carts['transactiondetails']	= $temp_varian;
						$temp_carts['status']				= 'cart';

						$API_order 							= new APIUser;
						$result 							= $API_order->postMeOrder($temp_carts);

					// result
						if (isset($result['message']))
						{
							$error 							= $result['message'];
						}
					}
				}	
			
				if(Session::has('redirect_url'))
				{
					$redirect 							= Session::get('redirect_url');
					Session::forget('redirect_url');
					return Redirect::to($redirect);
				}

				return Redirect::route('my.balin.redeem.index');
			}

			return Redirect::route('balin.get.login', ['type' => 'login'])
							->withErrors($result['message'])
							->with('msg-type', 'danger');
		}

		return Redirect::route('balin.get.login', ['type' => 'login'])
						->withErrors($validating->errors())
						->with('msg-type', 'danger');
	}

	/**
	 * function to get logout system
	 *
	 * @return home url
	 */
	public function getLogout()
	{
		Session::flush();

		return Redirect::route('balin.home.index');
	}

	/**
	 * function to activate user account
	 *
	 * @param activation link
	 */
	public function getActive($activation_link = null)
	{
		$breadcrumb										= 	[
																'Aktivasi' => ''
															];
		/* set api token use token public */
		Session::set('API_token', Session::get('API_token_public'));

		$API_me 										= new APIUser;
		$result 										= $API_me->postActivationLink([
																'link'	=> $activation_link,
															]);

		if (isset($result['message']))
		{
			return Redirect::route('balin.home.index');
		}
		else
		{
			$this->page_attributes->data 				= 	[
																'me'	=> $result['data'],
															];

			$this->page_attributes->subtitle 			= 'Aktivasi';
			$this->page_attributes->breadcrumb			= array_merge($breadcrumb);
			$this->page_attributes->source 				= 'web_v2.pages.profile.activation.index';
			$this->base_path_view 						= '';

			return $this->generateView();
		}
	}
}