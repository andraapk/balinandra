<?php namespace App\Http\Controllers\Me;

use App\API\Connectors\APIUser;
use App\API\Connectors\APISendMail;

use App\Http\Controllers\BaseController;

use App\Http\Controllers\Me\Veritrans\Veritrans_Config;
use App\Http\Controllers\Me\Veritrans\Veritrans_Transaction;

use Session;

class OrderController extends BaseController 
{
	protected $controller_name 						= 'order';

	function __construct()
	{
		parent::__construct();

		Session::set('API_token', Session::get('API_token_private'));

		$this->page_attributes->title 				= 'BALIN.ID';
	}

	/**
	 * function to generate view show particular order
	 *
	 * @return view
	 */
	public function show($id = null)
	{		
		//1. Ambil data order detail dari API
		$APIUser 							= new APIUser;

		$me_order_detail					= $APIUser->getMeOrderDetail([
													'user_id' 	=> Session::get('whoami')['id'],
													'order_id'	=> $id
												]);
		if($me_order_detail['status']!='success')
		{
			\App::abort(404);
		}

		//2. parsing data dari API
		$data 								= 	[
													'order' 	=> $me_order_detail['data'],
												];

  		$balin 								= $this->balin;

		//3. Generate view
		$page 								= view('web_v2.pages.profile.order.show', compact('balin'))->with('data', $data);

		return $page;
	}

	/**
	 * function to cancel order
	 *
	 * @return redirect url
	 */
	public function destroy($id = null)
	{		
		//1.  ambil data order detail dari API
		$APIUser 								= new APIUser;

		$me_order_detail						= $APIUser->getMeOrderDetail([
													'user_id' 	=> Session::get('whoami')['id'],
													'order_id'	=> $id
												]);

		if($me_order_detail['status']!='success')
		{
			\App::abort(404);
		}

		$is_veritrans 							= false;

		if(strtolower($me_order_detail['data']['status'])=='veritrans_processing_payment')
		{
			$is_veritrans 						= true;
		}

		//2.  Set status cancel
		$me_order_detail['data']['status']		= 'canceled';

		//3.  Store order
		$order									= $APIUser->postMeOrder($me_order_detail['data']);

		//4. Check order
		if ($order['status'] != 'success')
		{
			$this->errors						= $order['message'];
		}
		else
		{
			$infos 								= [];
			foreach ($this->balin['info'] as $key => $value) 
			{
				$infos[$value['type']]			= $value['value'];
			}
			
			$mail 								= new APISendMail;
			$result								= $mail->cancelorder($order['data'], $infos);
			
			if (isset($result['message']))
			{
				$this->errors					= $result['message'];
			}
			elseif($is_veritrans)
			{
				// Set our server key
				Veritrans_Config::$serverKey 			= env('VERITRANS_KEY', 'VT_KEY');

				// Uncomment for production environment
				Veritrans_Config::$isProduction 		= env('VERITRANS_PRODUCTION', false);

				// Comment to disable sanitization
				Veritrans_Config::$isSanitized 			= true;

				// Comment to disable 3D-Secure
				Veritrans_Config::$is3ds 				= true;

				$veritrans 								= Veritrans_Transaction::cancel($me_order_detail['data']['ref_number']);
			}
		}

		//5. Generate view
		$this->page_attributes->success 		= "Pesanan Anda sudah dibatalkan.";

		return $this->generateRedirectRoute('my.balin.profile');
	}

	/**
	 * function to resend invoice only order status 'wait'
	 */
	public function resend_invoice($id = null)
	{
		//1. Get order detail
		$APIUser 								= new APIUser;
		$order									= $APIUser->getMeOrderDetail(['user_id' 	=> Session::get('whoami')['id'], 'order_id' 	=> $id]);

		//2. Check order
		if ($order['status'] != 'success')
		{
			$this->errors						= $order['message'];
		}
		else
		{
			$infos 								= [];
			foreach ($this->balin['info'] as $key => $value) 
			{
				$infos[$value['type']]			= $value['value'];
			}

			$mail 								= new APISendMail;
			$result								= $mail->invoice($order['data'], $infos);
			
			// if (isset($result['message']))
			// {
			// 	$this->errors					= $result['message'];
			// }
		}

		$this->page_attributes->success 		= "Resend invoice terkirim.";

		return $this->generateRedirectRoute('my.balin.profile');
	}
}