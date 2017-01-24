<?php 
namespace App\API\Connectors;

use Exception, Session;

class APIConfig extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getIndex($parameter = null)
	{
		$this->api_url 					= '/balin/public/config';

		if(!is_null($parameter))
		{
			$this->api_data 				= array_merge($this->api_data, $parameter);
		}

		return $this->get();
	}
}