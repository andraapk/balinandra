<?php namespace App\Http\Controllers;

use App\API\Connectors\APIProduct;
use App\API\Connectors\APIUser;

use Input, Response, Redirect, Session, Collection;

use Illuminate\Support\MessageBag as MessageBag;

/**
 * Used for Cart (activities) Controller
 * 
 * @author agil
 */
class CartController extends BaseController 
{
	protected $controller_name 					= 'cart';

	public function __construct()
	{
		parent::__construct();

		if (Session::has('whoami'))
		{
			Session::put('API_token', Session::get('API_token_private'));
		}
		else
		{
			Session::put('API_token', Session::get('API_token_public'));
		}

		$this->page_attributes->title 				= 'BALIN.ID';
		$this->page_attributes->source 				= 'cart.';
		$this->page_attributes->breadcrumb			=	[
															'Cart' 	=> route('balin.cart.index'),
														];
	}

	/**
	 * function to generate index of cart
	 *
	 * @return view
	 */
	public function index()
	{	
		$carts 										= Session::get('carts');

		if (Session::has('whoami'))
		{
			$APIUser 								= new APIUser;
			$me_order_in_cart 						= $APIUser->getMeOrderInCart(['user_id' 	=> Session::get('whoami')['id']]);

			if($me_order_in_cart['status']!='success')
			{
				\App::abort(404);
			}

			$temp_carts 							= [];
			$temp_varians 							= [];

			foreach ($me_order_in_cart['data']['transactiondetails'] as $k => $v)
			{
				$temp_carts['slug']					= $v['varian']['product']['slug'];
				$temp_carts['name']					= $v['varian']['product']['name'];
				$temp_carts['discount']				= $v['discount'];
				$temp_carts['current_stock']		= $v['varian']['current_stock'];
				$temp_carts['thumbnail']			= $v['varian']['product']['thumbnail'];
				$temp_carts['price']				= $v['price'];
				
				if(!isset($carts[$v['varian']['product_id']]))
				{
					$carts[$v['varian']['product_id']]	= $temp_carts;
				}

				if($v['quantity']!=0)
				{
					$varian_temp[$v['varian']['id']]	= 	[
																'varian_id'			=> $v['varian']['id'],
																'quantity'			=> $v['quantity'],
																'size'				=> $v['varian']['size'],
																'current_stock'		=> $v['varian']['current_stock'],
																'message'			=> null,
															];
					$carts[$v['varian']['product_id']]['varians'][$v['varian']['id']]	= $varian_temp[$v['varian']['id']];
				}
			}
		}

		if (!empty($carts) && is_array($carts)) 
		{
			foreach ($carts as $key => $value) 
			{
				if(isset($value['varians']))
				{
					foreach ($value['varians'] as $key2 => $value2) 
					{
						if($value2['quantity'] < 1)
						{
							unset($carts[$key]['varians'][$key2]);
						}
					}

					if(count($value['varians'])<1)
					{
						unset($carts[$key]);
					}
				}
			}
		}

		Session::put('carts', $carts);

		$breadcrumb									= 	[
															'Shopping Bag' => route('balin.cart.index')
														];

		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);
														
		$this->page_attributes->data				= 	[
															'carts' 	=> $carts,
														];

		$this->page_attributes->subtitle 			= 'Shopping Bag';
		$this->page_attributes->source 				=  $this->page_attributes->source . 'index';
		// $this->base_path_view 						= '';

		return $this->generateView();
	}

	/**
	 * function to store an item to cart
	 *
	 * 1. Check existance of product
	 * 2. Parsing data
	 * 3. call add to cart function
	 * 4. return response
	 * @param slug
	 */
	public function store($slug = null)
	{
		//1. Check existance of product
		$APIProduct 						= new APIProduct;
		$product 							= $APIProduct->getIndex(['search' 	=> 	['slug' 	=> $slug]]);

		if($product['data']['count'] < 1 )
		{
			\App::abort(404);
		}

		//2. Parsing data
		$carts 								= Session::get('carts');
		$qty 								= Input::get('qty');
		$varianids 							= Input::get('varianids');

		$varians 							= [];
		$qtys 								= [];

		foreach ($varianids as $key => $value) 
		{
			//add current cart counts
			$prod_id 						= $product['data']['data'][0]['id'];
			if(isset($carts[$prod_id]['varians'][$value]['quantity'])){
				$cur_qty					= $carts[$prod_id]['varians'][$value]['quantity'];
			}else{
				$cur_qty					= 0;
			}
			$qty[$key]						= $qty[$key] + $cur_qty;
			// end add current cart counts

			$varians[$value] 				= $value;
			$qtys[$value]					= $qty[$key];
		}

		//3. call add to cart function
		$cart								= $this->addToCart($carts, $product['data']['data'][0], $qtys, $varians);

		$carts 								= Session::put('carts', $cart['data']);

		//4. return response
		if($cart['status']==true)
		{
			return Response::json(['carts' => $cart['data']], 200);
		}
		
		return Response::json(['carts' => $cart['data'], 'message' => $cart['message']], 200);
	}

	/**
	 * function to update an item to cart
	 *
	 * 1. Check existance of product
	 * 2. Parsing data
	 * 3. call add to cart function
	 * 4. return response
	 * @param slug, varian id
	 */
	public function update($slug = null, $varian_id = null)
	{
		//1. Check existance of product
		$APIProduct 						= new APIProduct;
		$product 							= $APIProduct->getIndex(['search' 	=> 	['slug' 	=> $slug]]);

		if($product['data']['count'] < 1 )
		{
			\App::abort(404);
		}

		//2. Parsing data
		$carts 								= Session::get('carts');
		$product_id							= $product['data']['data'][0]['id'];

		$carts[$product_id]['varians'][$varian_id]['quantity']	= Input::get('qty');

		$varianids 							= [];
		$qtys 								= [];

		foreach ($carts[$product_id]['varians'] as $key => $value) 
		{
			$varianids[$key] 				= $key;
			$qtys[$key]						= $value['quantity'];
		}

		//3. call add to cart function
		$cart								= $this->addToCart($carts, $product['data']['data'][0], $qtys, $varianids);

		Session::put('carts', $cart['data']);

		$carts 								= $cart['data'];

		if (count($carts) == 0)
		{
			Session::flash('carts', 'remove carts');
		}

		//4. return response
		if($cart['status']=='success')
		{
			return Response::json(['carts' => $cart['data']], 200);
		}
		
		return Response::json(['carts' => $cart['data'], 'message' => $cart['message']], 200);
	}

	/**
	 * function to get cart dropdown
	 *
	 * @return view
	 */
	public function getListBasket() 
	{
		if (!Session::has('whoami'))
		{
			$APIProduct 					= new APIProduct;
			$recommend 						= $APIProduct->getIndex([
													'search' 	=> 	[
																		'name' 	=> Input::get('q'),
																		'recommended' => 0,
																	],
													'sort' 		=> 	[
																		'name'	=> 'asc',
																	],
													'take'		=> 2,
													'skip'		=> '',
												]);
		}
		else
		{
			Session::set('API_token', Session::get('API_token_private'));

			$APIProduct 					= new APIProduct;
			$recommend 						= $APIProduct->getIndex([
													'search' 	=> 	[
																		'name' 	=> Input::get('q'),
																		'recommended' => Session::get('whoami')['id'],
																	],
													'sort' 		=> 	[
																		'name'	=> 'asc',
																	],
													'take'		=> 2,
													'skip'		=> '',
												]);
			}
  		

		return View('web_v2.components.cart.list_ajax_cart_dropdown', compact('recommend'));
	}

	/**
	 * function to store an item to cart or transaction detail
	 *
	 * 1. Parsing data
	 * 2. Check quantity of varian
	 * 3. Check logged user
	 * 4. return data
	 * @param current cart, changes product, changes qty, changes varian
	 */
	function addToCart($temp_carts, $product, $qtys, $varianids) 
	{
		//1. Parsing data
		$errors 	 						= new MessageBag();

		//2. Check quantity of varian
		foreach ($varianids as $key => $value) 
		{
			//2a. get valid quantity of varian
			if (isset($qtys[$value]) && $qtys[$value]!=0 && isset($temp_carts[$product['id']]['varians'][$value]))
			{
				$validqty 					= $qtys[$value];
			}
			elseif(isset($temp_carts[$product['id']]['varians'][$value]) && $qtys[$value]!=0)
			{
				$validqty 					= $temp_carts[$product['id']]['varians'][$value]['quantity']; 
			}
			else
			{
				$validqty 					= $qtys[$value];
			}

			//2b. collect varian from product
			foreach ($product['varians'] as $key2 => $value2) 
			{
				if($value2['id']==$value)
				{
					$varianp 						= $value2;
				}
			}

			//2c. check varian stock
			if (isset($varianp))
			{
				if ($varianp['current_stock'] < $validqty || $varianp['current_stock'] == 0)
				{
					$errors->add('Stock', $product['name']. ' tidak tersedia dalam ukuran '.$varianp['size'].'.');
				}
			}
			// else
			// {
			// 	$errors->add('Stock', $product['name']. ' tidak tersedia dalam ukuran yang dicari.');
			// }

			//2d. parsing detail
			if (!$errors->count() && $validqty!=0 && isset($varianp))
			{
				if(!isset($temp_carts[$product['id']]))
				{
					$temp_carts[$product['id']] 				= $product;
					$temp_carts[$product['id']]['discount']		= ($product['promo_price']!=0 ? ($product['price'] - $product['promo_price']) : 0);
					unset($temp_carts[$product['id']]['varians']);
				}

				$temp_cart						= 	
													[	
														'varian_id' 		=> $varianp['id'], 
														'sku'				=> $varianp['sku'],
														'quantity' 			=> $validqty, 
														'size' 				=> $varianp['size'], 
														'current_stock' 	=> $varianp['current_stock'],
													];
				
				if(isset($temp_carts[$product['id']]['varians'])){

					//sort by varian size
					$tmp 						= $temp_carts[$product['id']]['varians'];

					//empty current cart
					$temp_carts[$product['id']]['varians'] = [];

					//sorting
					foreach ($tmp as $key => $value) {
						$sizeComparison 		= new Helpers\SizeComparison;

						if($sizeComparison->isSmaller($temp_cart['size'],$value['size']) == true){
							$temp_carts[$product['id']]['varians'][$varianp['id']] = $temp_cart;
							$temp_carts[$product['id']]['varians'][$value['varian_id']] = $value;
						}else{
							$temp_carts[$product['id']]['varians'][$value['varian_id']] = $value;

							//last array and current is larger
							if(end($tmp)['varian_id'] == $key){
								$temp_carts[$product['id']]['varians'][$varianp['id']] = $temp_cart;
							}
						}
					}
				}else{
					$temp_carts[$product['id']]['varians'][$varianp['id']] = $temp_cart;
				}
			}
			elseif(!$errors->count() && $validqty==0 && isset($temp_carts[$product['id']]) && isset($varianp))
			{
				unset($temp_carts[$product['id']]['varians'][$varianp['id']]);
			}
		}

		// Check if temp carts is 0 to flash session carts
		if (count($temp_carts)==0)
		{
			Session::flash('carts', 'remove carts');
		}
		// check if product varians is 0 to unset product id in carts
		elseif (count($temp_carts[$product['id']]['varians'])==0)
		{
			unset($temp_carts[$product['id']]);
		}

		//3. Check logged user
		if (Session::has('whoami') && !$errors->count())
		{
			//3a. Check cart
			$APIUser 						= new APIUser;
			$order_in_cart 					= $APIUser->getMeOrderInCart(['user_id' => Session::get('whoami')['id']]);

			if($order_in_cart['status']!='success')
			{
				$order['id']					= '';
				$order['transactiondetails']	= [];
			}
			else
			{
				$order['id']					= $order_in_cart['data']['id'];
				$order['voucher_id']			= $order_in_cart['data']['voucher_id'];
				$order['transactiondetails']	= $order_in_cart['data']['transactiondetails'];
				$order_detail 					= [];
			}

			//3b. Check transactiondetail
			foreach ($temp_carts as $key => $value) 
			{
				foreach ($value['varians'] as $key2 => $value2) 
				{
					$id 						= '';
					foreach ($order['transactiondetails'] as $key3 => $value3) 
					{
						if($value3['varian_id'] == $value2['varian_id'])
						{
							$id 				= $value3['id'];
						}
						else
						{
							$id 				= '';
						}
					}

					$varian 					= 	[
														'id' 				=> $id,
														'varian_id' 		=> $value2['varian_id'],
														'quantity' 			=> $value2['quantity'],
														'price' 			=> $value['price'],
														'discount' 			=> $value['discount'],

													];
					if($value2['quantity'] > 0)
					{
						$order_detail[]			= $varian;
					}
				}
			}

			if(empty($temp_carts))
			{
				$order_detail 					= null;
			}

			$order['transactiondetails'] 		= $order_detail;
			$order['status'] 					= 'cart';
			$order['user_id'] 					= Session::get('whoami')['id'];

			//3c. Store cart
			$result 							= $APIUser->postMeOrder($order);

			//3d. check result
			if (isset($result['message']))
			{
				$errors->add('Cart', $result['message']);
			}
		}

		//4. return data
		if($errors->count())
		{
			return ['status' => false, 'data' => $temp_carts, 'message' => $errors];
		}
		// dd($temp_carts);
		return ['status' => true, 'data' => $temp_carts];
	}
}