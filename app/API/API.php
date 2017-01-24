<?php namespace App\API;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

use Response;

class API
{
	protected $domain;
	protected $port;
	protected $lives 			= 10;

	public $timeout				= 100;
	public $basic_url;

	public function __construct()
	{
		$this->domain 			= env('RESOURCE_DOMAIN', 'localhost');
		$this->port 			= env('RESOURCE_PORT', '');
		
		$this->basic_url 		= $this->domain;

		if(!is_null($this->port))
		{
			if(!empty($this->port))
			{
				$this->basic_url = $this->basic_url . ':' . $this->port;
			}
		}
	}

	public function get($url)
	{
		// try{
			$client 				= new Client([
											'base_uri' => $this->basic_url,
										    'timeout'  => $this->timeout
										]);

			$request 				= new Request('GET',  $this->basic_url . $url);
			$response 				= $client->send($request, ['timeout' => $this->timeout]);
			
			$body 					= $response->getBody();

			return (string) $body;
		// } catch (Exception $e) {
		// 	if($this->lives > 0){
		// 		$this->lives = $this->lives - 1;
		// 		$this->post($url);
		// 	}else{
		// 		return view('errors.503');
		// 	}
		// }		
	}

	public function post($url, $data = [])
	{
		// try{
			$client 				= new Client([
											'base_uri' => $this->basic_url,
										    'timeout'  => $this->timeout,
										]);

			$response 				= $client->request('POST',  $this->basic_url . $url, ['form_params' => $data] );

			$body 					= $response->getBody();

			return (string) $body;
		// } catch (Exception $e) {
		// 	if($this->lives > 0){
		// 		$this->lives = $this->lives - 1;
		// 		$this->post($url, $data);
		// 	}else{
		// 		return view('errors.503');
		// 	}
		// }
	}

	public function delete($url, $data = [])
	{
		// try{
			$client 				= new Client([
											'base_uri' => $this->basic_url,
										    'timeout'  => $this->timeout,
										]);


			$request 				= new Request('DELETE',  $this->basic_url . $url);
			$response 				= $client->send($request, ['timeout' => $this->timeout]);

			$body 					= $response->getBody();

			return (string) $body;
		// } catch (Exception $e) {
		// 	if($this->lives > 0){
		// 		$this->lives = $this->lives - 1;
		// 		$this->post($url, $data);
		// 	}else{
		// 		return view('errors.503');
		// 	}
		// }
	}	
}