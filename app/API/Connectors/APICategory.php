<?php 
namespace App\API\Connectors;

class APICategory extends APIData {
	function __construct() 
	{
		parent::__construct();
		$this->api_data 					= array_merge($this->api_data, ['type' => 'category']);
	}

	public function getIndex($filter = null)
	{
		$this->api_url 						= '/balin/public/clusters/category';

		if (!is_null($filter))
		{
			$this->api_data 				= array_merge($this->api_data, $filter);
		}

		return $this->get();
	}
}