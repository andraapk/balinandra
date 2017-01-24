<?php 
namespace App\API\connectors;

class APITag extends APIData {
	function __construct() 
	{
		parent::__construct();
		$this->api_data 					= array_merge($this->api_data, ['type' => 'tag']);
	}

	public function getIndex($filter = null)
	{
		$this->api_url 						= '/balin/public/clusters/tag';

		if(!is_null($filter))
		{
			$this->api_data 				= array_merge($this->api_data, $filter);
		}

		return $this->get();
	}
}