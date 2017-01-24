<?php 
namespace App\API\Connectors;

class APIProductExtension extends APIData {
	
	public function getIndex($filter = null)
	{
		$this->api_url 						= '/balin/public/extensions';

		if (!is_null($filter))
		{
			$this->api_data 				= array_merge($this->api_data, $filter);
		}

		return $this->get();
	}
}