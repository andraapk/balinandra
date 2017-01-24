<?php 
namespace App\API\Connectors;

use App\API\API;
use Exception, Session, Redirect;

abstract class APIData
{
	protected $api_url;
	protected $api_data;

	function __construct() 
	{
		$this->api 						= new API;

		$this->api_data 				= ['token' => Session::get('API_token')];
		
		if(is_null(Session::get('API_token')))
		{
			Redirect::route('balin.home.index')->send();
		}
	}

	protected function get()
	{
		$queryString 				= http_build_query($this->api_data);

		$queryString 				= str_replace(' ', '%20', $queryString);

		$this->api_url				= $this->api_url . '?' . $queryString;

		$result 					= json_decode($this->api->get($this->api_url), true);

		return $this->validateResponse($result);
	}

	protected function post()
	{
		$result 					= json_decode($this->api->post($this->api_url, $this->api_data),true);

		return $this->validateResponse($result);
	}

	protected function delete()
	{
		$queryString 				= null;

		foreach ($this->api_data as $key => $data) 
		{
			$queryString 			= $queryString . $key . '=' . $data . '?' ;
		}

		$this->api_url				= $this->api_url . '?' . $queryString;

		$result 					= json_decode($this->api->delete($this->api_url), true);		

		return $this->validateResponse($result);
	}	

	private function validateResponse($result)
	{
		// validate response
		try 
		{
		    if(empty($result['status']))
		    {
		    	Redirect::route('page.error', ['header' => '500', 'msg' => 'No status from server']);
		    }
		} 
		catch (Exception $e) 
		{
			Redirect::route('page.error', ['header' => '500', 'msg' => 'Unknown response from server']);
		}

		// data
		if(!isset($result['data']) || is_null($result['data']))
		{
			$result['data'] 		= [];
		}

		return $result;
	}
}