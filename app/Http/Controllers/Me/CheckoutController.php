<?php namespace App\Http\Controllers\Me;

use App\API\Connectors\APIUser;
use App\API\Connectors\APIProductExtension;
use App\API\Connectors\APISendMail;
use App\API\Connectors\APICourier;

use App\Http\Controllers\BaseController;

use App\Http\Controllers\Me\Veritrans\Veritrans_Config;
use App\Http\Controllers\Me\Veritrans\Veritrans_Transaction;
use App\Http\Controllers\Me\Veritrans\Veritrans_ApiRequestor;
use App\Http\Controllers\Me\Veritrans\Veritrans_Notification;
use App\Http\Controllers\Me\Veritrans\Veritrans_VtDirect;
use App\Http\Controllers\Me\Veritrans\Veritrans_VtWeb;
use App\Http\Controllers\Me\Veritrans\Veritrans_Sanitizer;

use Input, Response, Redirect, Session, Request, BalinMail;

/**
 * Used for Checkout Controller
 * 
 * @author cmooy
 */
class CheckoutController extends BaseController 
{
	protected $controller_name 					= 'checkout';

	public function __construct()
	{
		parent::__construct();

		Session::put('API_token', Session::get('API_token_private'));

		$this->page_attributes->title 			= 'BALIN.ID';
		$this->page_attributes->source 			= '.checkout.';
		$this->page_attributes->breadcrumb		=	[
														'Checkout' 	=> route('my.balin.checkout.get'),
													];
	}

	/**
	 * function to get summary of balin checkout
	 * 
	 * 1. Get Session Cart & transaction
	 * 2. Generate breadcrumb
	 * 3. Generate view
	 * @return view
	 */
	public function get()
	{	
		//1.Get Session Cart & transaction
		$carts 									= Session::get('carts');

		$APIUser 								= new APIUser;
		$order 									= $APIUser->getMeOrderInCart(['user_id' 	=> Session::get('whoami')['id']]);

		if($order['status']!='success')
		{
			Session::forget('carts');

			\App::abort(404);
		}

		//1a. get my point
		$my_point 								= $APIUser->getMeDetail([
														'user_id'	=> Session::get('whoami')['id'],
													]);

		//1b. get my address
		$my_address 							= $APIUser->getMeAddress([
													'user_id' 	=> Session::get('whoami')['id'],
												]);

		//1c. get list product extension
		$APIProductExtension 					= new APIProductExtension;
		$product_extension						= $APIProductExtension->getIndex();

		if($product_extension['status']!='success')
		{
			$product_extension					= null;
		}

		//1d. get list product extension
		$APICourier 							= new APICourier;
		$courier								= $APICourier->getIndex();

		if($courier['status']!='success')
		{
			$courier							= null;
		}

		//2. Generate breadcrumb
		$breadcrumb								= 	[
														'Checkout' => route('my.balin.checkout.get')
													];

		$this->page_attributes->breadcrumb		= array_merge($this->page_attributes->breadcrumb, $breadcrumb);
		
		//3. Generate view
		$this->page_attributes->data			= 	[
														'carts'				=> $carts,
														'order'				=> $order,
														'my_point'			=> $my_point['data']['total_point'],
														'my_address'		=> $my_address['data']['data'],
														'product_extension'	=> $product_extension,
														'courier'			=> $courier['data']['data'],
													];

		$this->page_attributes->controller_name	= $this->controller_name;
		$this->page_attributes->subtitle 		= 'Checkout';
		$this->page_attributes->source 			=  $this->page_attributes->source . 'index';

		return $this->generateView();
	}

	/**
	 * function to post summary of balin checkout
	 * 
	 * 1. Get Session Cart & transaction
	 * 2. Parsing variable
	 * 3. Store checkout
	 * 4. Check result, send mail
	 * 5. Redirect url
	 * @return redirect url
	 */
	public function post($slug = null)
	{
		//1. Get Session Cart & transaction
		$APIUser 								= new APIUser;

		$me_order_in_cart 						= $APIUser->getMeOrderInCart(['user_id' 	=> Session::get('whoami')['id']]);

		if(count($me_order_in_cart['data']['transactiondetails']) == 0 )
		{
			\App::abort(404);
		}

		//2. Parsing variable
		if($me_order_in_cart['status']!='success')
		{
			Session::forget('carts');

			\App::abort(404);
		}

		$temp_transaction 						= $me_order_in_cart['data'];

		//2a.change status
		$temp_transaction['status']				= 'wait';

		//3. Store checkout
		$order 									= $APIUser->postMeOrder($temp_transaction);

		//4. Check order, send mail
		if ($order['status'] != 'success')
		{
			$this->errors 						= $order['message'];
		}

		//5. Redirect url
		$this->page_attributes->success 			= "Terima Kasih, pesanan Anda sudah kami terima. Segera validasi pembayaran Anda.";

		if(Session::has('veritrans_payment'))
		{
			// Set our server key
			Veritrans_Config::$serverKey 			= env('VERITRANS_KEY', 'VT_KEY');

			// Uncomment for production environment
			Veritrans_Config::$isProduction 		= env('VERITRANS_PRODUCTION', false);

			// Comment to disable sanitization
			Veritrans_Config::$isSanitized 			= true;

			// Comment to disable 3D-Secure
			Veritrans_Config::$is3ds 				= true;

			// Fill transaction data
			$transaction_details 					= 	[
													        'order_id' 			=> $order['data']['ref_number'],
													        'gross_amount' 		=> $order['data']['bills'], // no decimal allowed for creditcard
		    											];
		    $item_details 							= 	[];
		    $i 										= 	0;

		    foreach ($order['data']['transactiondetails'] as $key => $value) 
		    {
		    	$item_details[$i]['id']				= $value['varian']['sku'];
		    	$item_details[$i]['name']			= $value['varian']['product']['name'].' Ukuran '.$value['varian']['size'];
		    	$item_details[$i]['price']			= $value['price'] - $value['discount'];
		    	$item_details[$i]['quantity']		= $value['quantity'];
		    	$i 									= $i + 1;
		    }

		    $item_details[$i]['id']					= $i;
		    $item_details[$i]['name']				= 'Ongkos Kirim';
		    $item_details[$i]['price']				= $order['data']['shipping_cost'];
	    	$item_details[$i]['quantity']			= 1;
	    	$i 										= $i + 1;

		    $item_details[$i]['id']					= $i;
		    $item_details[$i]['name']				= 'Potongan Voucher';
		    $item_details[$i]['price']				= 0 - abs($order['data']['voucher_discount']);
	    	$item_details[$i]['quantity']			= 1;
	    	$i 										= $i + 1;

		    $item_details[$i]['id']					= $i;
		    $item_details[$i]['name']				= 'Potongan Point';
		    $item_details[$i]['price']				= 0 - abs($order['data']['point_discount']);
	    	$item_details[$i]['quantity']			= 1;
	    	$i 										= $i + 1;

		    $item_details[$i]['id']					= $i;
		    $item_details[$i]['name']				= 'Potongan Transfer';
		    $item_details[$i]['price']				= 0 - abs($order['data']['unique_number']);
	    	$item_details[$i]['quantity']			= 1;
	    	$i 										= $i + 1;

		    $item_details[$i]['id']					= $i;
		    $item_details[$i]['name']				= 'Biaya Tambahan';
		    $item_details[$i]['price']				= $order['data']['extend_cost'];
	    	$item_details[$i]['quantity']			= 1;
	    	$i 										= $i + 1;

			// Optional
			$billing_address 						= 	[
															'first_name'		=> $order['data']['customer']['name']
														];

			// Optional
			$shipping_address 						= 	[
															'first_name'		=> $order['data']['shipment']['receiver_name'],
															'address'			=> $order['data']['shipment']['address']['address'],
															'postal_code'		=> $order['data']['shipment']['address']['zipcode'],
															'phone'				=> $order['data']['shipment']['address']['phone'],
														];

			// Optional
			$customer_details 						= 	[
															'first_name'		=> $order['data']['customer']['name'],
															'email'				=> $order['data']['customer']['email'],
															'billing_address'	=> $billing_address,
															'shipping_address'	=> $shipping_address,
														];

			// Fill transaction details
			$transaction 							=	[
															'transaction_details'	=> $transaction_details,
															'customer_details'		=> $customer_details,
															'item_details'			=> $item_details,
														];

			$vtweb_url 								= Veritrans_Vtweb::getRedirectionUrl($transaction);
			
			Session::forget('veritrans_payment');

			// Redirect
			dd(header('Location: ' . $vtweb_url));
		}

		Session::forget('carts');

		return $this->generateRedirectRoute('my.balin.profile', ['order_id' => $order['data']['id']]);
	}

	/**
	 * function to get voucher discount
	 * 
	 * 1. Get cart detail
	 * 2. check my referral
	 * 2. Store voucher
	 * 3. Return result
	 * @return json response
	 */
	public function voucher()
	{
		//1. Get cart detail
		$APIUser 								= new APIUser;

		$me_order_in_cart 						= $APIUser->getMeOrderInCart(['user_id' 	=> Session::get('whoami')['id']]);

		if ($me_order_in_cart['status']!= 'success')
		{
			return Response::json(['type' => 'error', 'msg' => 'Tidak ada keranjang.'], 200);
		}
		//2. Store voucher
		$voucher 										= Input::get('voucher');
		$me_order_in_cart['data']['voucher']['code']	= $voucher;

		$result 									= $APIUser->postMeOrder($me_order_in_cart['data']);

		//3. Return result
		if (isset($result['message']))
		{
			return Response::json(['type' => 'error', 'msg' => $result['message']], 200);
		}

		if ($result['data']['voucher']['type']=='free_shipping_cost')
		{
			return Response::json(['type' => 'success', 'msg' => 'Selamat! Anda mendapat potongan : gratis biaya pengiriman.', 'discount' => $result['data']['voucher_discount'], 'action' => route('my.balin.checkout.get.order', $result['data']['id']) ], 200);
		}
		elseif($result['data']['voucher'])
		{
			return Response::json(['type' => 'success', 'msg' => 'Selamat! Anda mendapat bonus balin point sebesar '.$result['data']['voucher']['value'].' (Balin Point akan ditambahkan jika pesanan sudah dibayar)', 'discount' => false, 'action' => route('my.balin.checkout.get.order', $result['data']['id'])], 200);
		}
		else
		{
			return Response::json(['type' => 'success', 'msg' => 'Selamat! Voucher Anda di konversikan menjadi point untuk pembayaran.', 'discount' => false, 'action' => route('my.balin.checkout.get.order', $result['data']['id'])], 200);
		}
	}

	/**
	 * function to get shipping cost
	 * 
	 * 1. Get cart detail
	 * 2. Store shipment
	 * 3. Return result
	 * @return json response
	 */
	public function shipping()
	{
		//1. Get cart detail
		$APIUser 								= new APIUser;

		$me_order_in_cart 						= $APIUser->getMeOrderInCart(['user_id' 	=> Session::get('whoami')['id']]);

		if($me_order_in_cart['status']!= 'success')
		{
			return Response::json(['type' => 'error', 'msg' => 'Tidak ada keranjang.'], 200);
		}

		//2. Store shipment
		if(!isset($me_order_in_cart['data']['shipment']))
		{
			$me_order_in_cart['data']['shipment']['id']							= '';
			$me_order_in_cart['data']['shipment']['courier_id']					= 1;
		}

		if(!isset($me_order_in_cart['data']['shipment']['address_id']))
		{
			$me_order_in_cart['data']['shipment']['address_id']					= "";
			$me_order_in_cart['data']['shipment']['address']['id']				= "";
			$me_order_in_cart['data']['shipment']['receiver_name']				= Input::get('name');
			$me_order_in_cart['data']['shipment']['address']['address']			= Input::get('address');
			$me_order_in_cart['data']['shipment']['address']['zipcode']			= Input::get('zipcode');
			$me_order_in_cart['data']['shipment']['address']['phone']			= Input::get('phone');
		}
		else
		{
			if($me_order_in_cart['data']['shipment']['address_id']==0)
			{
				$me_order_in_cart['data']['shipment']['address']['id']			= "";
			}

			$me_order_in_cart['data']['shipment']['receiver_name']				= Input::get('name');
			$me_order_in_cart['data']['shipment']['address']['address']			= Input::get('address');
			$me_order_in_cart['data']['shipment']['address']['zipcode']			= Input::get('zipcode');
			$me_order_in_cart['data']['shipment']['address']['phone']			= Input::get('phone');
		}

		$result 																= $APIUser->postMeOrder($me_order_in_cart['data']);

		//3. Return result
		if (isset($result['message']))
		{
			unset($me_order_in_cart['data']['shipment']['address']);
			$me_order_in_cart['data']['shipment']['address_id']					= "";

			$result2															= $APIUser->postMeOrder($me_order_in_cart['data']);

			return Response::json(['type' => 'error', 'msg' => $result['message']], 200);
		}

		// parsing array to json to parsing in form address
		$address = [	'address'			=> $result['data']['shipment']['address']['address'],
						'receiver_name'		=> $result['data']['shipment']['receiver_name'],
						'phone'				=> $result['data']['shipment']['address']['phone'],
						'zipcode'			=> $result['data']['shipment']['address']['zipcode'],
					];
					
		return Response::json(['action' => route('my.balin.checkout.get.order', $result['data']['id']), 'address' => $address], 200);
	}

	/**
	 * function to store extension
	 * 
	 * 1. Get cart detail
	 * 2. Store extension
	 * 3. Return result
	 * @return json response
	 */
	public function extension()
	{
		//1. Get cart detail
		$APIUser				= new APIUser;

		$me_order_in_cart		= $APIUser->getMeOrderInCart(['user_id' 	=> Session::get('whoami')['id']]);

		if($me_order_in_cart['status']!= 'success')
		{
			return Response::json(['type' => 'error', 'msg' => 'Tidak ada keranjang.'], 200);
		}

		//2. Store extension
		$extension 				= Input::only('product_extension_id', 'value', 'price', 'flag');
		$extensions 			= [];
		if(!empty($extension['product_extension_id']))
		{
			foreach ($extension['product_extension_id'] as $key => $value) 
			{
				if($value!='' && $extension['flag'][$key]==true)
				{
					$extensions[]	= ['id' => '', 'transaction_id' => $me_order_in_cart['data']['id'], 'product_extension_id' => $value, 'price' => $extension['price'][$key], 'value' => $extension['value'][$key]];
				}
			}
		}

		$me_order_in_cart['data']['transactionextensions']	= $extensions;

		$result					= $APIUser->postMeOrder($me_order_in_cart['data']);

		//3. Return result
		if (isset($result['message']))
		{
			return Response::json(['type' => 'error', 'msg' => $result['message']], 200);
		}

		return Response::json(['type' => 'success', 'msg' => 'Bingkisan sudah tersimpan (akan dikenakan biaya sesuai yang tertera).', 'action' => route('my.balin.checkout.get.order', $result['data']['id'])], 200);
	}

	public function choice_payment()
	{
		$payment_method 		= Input::get('choice_payment');

		if($payment_method=='veritrans')
		{
			Session::put('veritrans_payment', true);
		}
		else
		{
			Session::forget('veritrans_payment');
		}

		return Response::json(['type' => 'success', 'msg' => $payment_method], 200);
	}

	/**
	 * function to get view desktop for order detail in checkout
	 * 1. Get cart detail
	 * 2. return to view
	 */
	public function get_view($id = null)
	{
		// 1. Get detail Order
		$APIUser								= new APIUser;
		$result 								= $APIUser->getMeOrderInCart(['user_id' 	=> Session::get('whoami')['id']]);

		// 2. generate from ajax to view for order detail same for index
		// 2.a. session carts
		$carts									= Session::get('carts');

		// 2.b. get order from API setelah shipping cost
		$order 									= $result['data'];

		$data 			= 	[
								'carts'			=> Session::get('carts'),
								'order' 		=> $result['data'],
							];
		// 2.c. get model view to return
		$model 			= (Input::get('model') != 'mobile') ? 'desktop' : 'mobile';

		return View('web_v2.components.checkout.part_total_order_'. $model)->with('data', $data);
	}

	public function checkdoout($id = null)
	{
		//1. Ambil data order detail dari API
		$APIUser 							= new APIUser;

		$me_order_detail					= $APIUser->getMeOrderDetail([
													'user_id' 	=> Session::get('whoami')['id'],
													'order_id'	=> $id
												]);
		
		if ($me_order_detail['status']!='success')
		{
			\App::abort(404);
		}

		//2. parsing data dari API
		$data 								= 	[
													'order' 	=> $me_order_detail['data'],
												];

  		$balin 								= $this->balin;

		//3. Generate view
		$page 								= view('web_v2.components.checkout.info_checkout', compact('balin'))
												->with('data', $data);

		return $page;
	}

	/**
	 * function to post summary of balin checkout
	 * 
	 * 1. Get Session Cart & transaction
	 * 2. Parsing variable
	 * 3. Store checkout
	 * 4. Check result, send mail
	 * 5. Redirect url
	 * @return redirect url
	 */
	public function vtprocessing($order_id = null)
	{
		//1. Ambil data order detail dari API
		$APIUser 							= new APIUser;

		$me_order_detail					= $APIUser->getMeOrderDetail([
													'user_id' 	=> Session::get('whoami')['id'],
													'order_id'	=> $order_id
												]);
		
		if ($me_order_detail['status']!='success')
		{
			\App::abort(404);
		}
		
		// Set our server key
		Veritrans_Config::$serverKey 			= env('VERITRANS_KEY', 'VT_KEY');

		// Uncomment for production environment
		Veritrans_Config::$isProduction 		= env('VERITRANS_PRODUCTION', false);

		// Comment to disable sanitization
		Veritrans_Config::$isSanitized 			= true;

		// Comment to disable 3D-Secure
		Veritrans_Config::$is3ds 				= true;

		// Fill transaction data
		$transaction_details 					= 	[
												        'order_id' 			=> $me_order_detail['data']['ref_number'],
												        'gross_amount' 		=> $me_order_detail['data']['bills'], // no decimal allowed for creditcard
	    											];
	    $item_details 							= 	[];
	    $i 										= 	0;

	    foreach ($me_order_detail['data']['transactiondetails'] as $key => $value) 
	    {
	    	$item_details[$i]['id']				= $value['varian']['sku'];
	    	$item_details[$i]['name']			= $value['varian']['product']['name'].' Ukuran '.$value['varian']['size'];
	    	$item_details[$i]['price']			= $value['price'] - $value['discount'];
	    	$item_details[$i]['quantity']		= $value['quantity'];
	    	$i 									= $i + 1;
	    }

	    $item_details[$i]['id']					= $i;
	    $item_details[$i]['name']				= 'Ongkos Kirim';
	    $item_details[$i]['price']				= $me_order_detail['data']['shipping_cost'];
    	$item_details[$i]['quantity']			= 1;
    	$i 										= $i + 1;

	    $item_details[$i]['id']					= $i;
	    $item_details[$i]['name']				= 'Potongan Voucher';
	    $item_details[$i]['price']				= 0 - abs($me_order_detail['data']['voucher_discount']);
    	$item_details[$i]['quantity']			= 1;
    	$i 										= $i + 1;

	    $item_details[$i]['id']					= $i;
	    $item_details[$i]['name']				= 'Potongan Point';
	    $item_details[$i]['price']				= 0 - abs($me_order_detail['data']['point_discount']);
    	$item_details[$i]['quantity']			= 1;
    	$i 										= $i + 1;

	    $item_details[$i]['id']					= $i;
	    $item_details[$i]['name']				= 'Potongan Transfer';
	    $item_details[$i]['price']				= 0 - abs($me_order_detail['data']['unique_number']);
    	$item_details[$i]['quantity']			= 1;
    	$i 										= $i + 1;

	    $item_details[$i]['id']					= $i;
	    $item_details[$i]['name']				= 'Biaya Tambahan';
	    $item_details[$i]['price']				= $me_order_detail['data']['extend_cost'];
    	$item_details[$i]['quantity']			= 1;
    	$i 										= $i + 1;

		// Optional
		$billing_address 						= 	[
														'first_name'		=> $me_order_detail['data']['customer']['name']
													];

		// Optional
		$shipping_address 						= 	[
														'first_name'		=> $me_order_detail['data']['shipment']['receiver_name'],
														'address'			=> $me_order_detail['data']['shipment']['address']['address'],
														'postal_code'		=> $me_order_detail['data']['shipment']['address']['zipcode'],
														'phone'				=> $me_order_detail['data']['shipment']['address']['phone'],
													];

		// Optional
		$customer_details 						= 	[
														'first_name'		=> $me_order_detail['data']['customer']['name'],
														'email'				=> $me_order_detail['data']['customer']['email'],
														'billing_address'	=> $billing_address,
														'shipping_address'	=> $shipping_address,
													];

		// Fill transaction details
		$transaction 							=	[
														'transaction_details'	=> $transaction_details,
														'customer_details'		=> $customer_details,
														'item_details'			=> $item_details,
													];
		$vtweb_url 								= Veritrans_Vtweb::getRedirectionUrl($transaction);
		
		Session::forget('veritrans_payment');

		// Redirect
		dd(header('Location: ' . $vtweb_url));
	}

	/**
	 * function to inform success payment
	 * 
	 * @return redirect url
	 */
	public function vtfinish()
	{
		//1. Ambil data order detail dari API
		$APIUser 							= new APIUser;

		$me_order_detail					= $APIUser->getMeOrderRef([
													'user_id' 		=> Session::get('whoami')['id'],
													'ref_number'	=> Input::get('order_id')
												]);

		if($me_order_detail['status']!='success')
		{
			\App::abort(404);
		}

		//2a.change status
		$me_order_detail['data']['status']	= 'veirtrans_processing_payment';

		//3. Store checkout
		$order 								= $APIUser->postMeOrder($me_order_detail['data']);

		//4. Check order, send mail
		if ($order['status'] != 'success')
		{
			$this->errors 						= $order['message'];
		}

		Session::forget('carts');

		$this->page_attributes->success = "Pembayaran Anda sudah tersimpan, BALIN akan memproses penerimaan pembayaran Anda dalam waktu kurang dari 24 jam.";

		return $this->generateRedirectRoute('my.balin.profile', ['order_id' => $order['data']['id']]);
	}

	/**
	 * function to inform failed payment
	 * 
	 * @return redirect url
	 */
	public function vtunfinish()
	{
		//1. Ambil data order detail dari API
		$APIUser 							= new APIUser;

		$order								= $APIUser->getMeOrderRef([
													'user_id' 		=> Session::get('whoami')['id'],
													'ref_number'	=> Input::get('order_id')
												]);
		if($order['status']!='success')
		{
			\App::abort(404);
		}

		Session::forget('carts');

		$this->errors 					= ["Pembayaran Anda sudah gagal tersimpan, Silahkan mencoba lagi atau membayar dengan opsi pembayaran lainnya."];

		return $this->generateRedirectRoute('my.balin.profile', ['order_id' => $order['data']['id']]);
	}
}