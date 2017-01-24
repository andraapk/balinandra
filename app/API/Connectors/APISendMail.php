<?php 
namespace App\API\Connectors;

class APISendMail extends APIData 
{
	function __construct() 
	{
		parent::__construct();

		$this->api->timeout 				= 30;
	}

	public function welcomemail($user, $store)
	{
		$this->api_url 						= '/mail/welcome';

		$this->api_data 					= array_merge($this->api_data, ["user" => $user, "store" => $store]);

		return $this->post();
	}	

	public function resetpassword($user, $store)
	{
		$this->api_url 						= '/mail/password/reset';

		$this->api_data 					= array_merge($this->api_data, ["user" => $user, "store" => $store]);

		return $this->post();
	}	

	public function invoice($invoice, $store)
	{
		$this->api_url 						= '/mail/invoice';

		$this->api_data 					= array_merge($this->api_data, ["invoice" => $invoice, "store" => $store]);

		return $this->post();
	}	

	public function cancelorder($order, $store)
	{
		$this->api_url 						= '/mail/canceled';

		$this->api_data 					= array_merge($this->api_data, ["order" => $order, "store" => $store]);

		return $this->post();
	}	

	public function invitation($user, $email, $store)
	{
		$this->api_url 						= '/mail/invitation';

		$this->api_data 					= array_merge($this->api_data, ["user" => $user, "email" => $email, "store" => $store]);

		return $this->post();
	}	

	public function contact($customer, $store)
	{
		$this->api_url 						= '/mail/contact';

		$this->api_data 					= array_merge($this->api_data, ["customer" => $customer, "store" => $store]);

		return $this->post();
	}	
}