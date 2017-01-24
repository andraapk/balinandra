<?php 
namespace App\API\Connectors;

use Exception, Session;

class APIProduct extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getIndex ($parameter = null)
	{
		if (!is_null($parameter))
		{
			$this->api_url 				= '/balin/public/products';
			$this->api_data				= array_merge($this->api_data, $parameter);
		}

		return $this->get();
	}

	public function getShow ($id)
	{
		$this->api_url 					= '/product/' . $id;

		return $this->get();
	}	
}