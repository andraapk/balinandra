<?php namespace App\Http\Controllers;

use Session, Config;

/**
 * Used for Product Controller
 * 
 * @author agil
 */
class ErrorController extends BaseController 
{	
	protected $controller_name 						= 'error';

	function __construct()
	{
		parent::__construct();

		if(Session::has('whoami'))
		{
			Session::put('API_token', Session::get('API_token_private'));
		}
		else
		{
			Session::put('API_token', Session::get('API_token_public'));
		}

		$this->page_attributes->title 				= 'BALIN.ID';
		$this->page_attributes->source 				= 'web_v2.pages.error.';
	}

	function er404($header = null, $msg = null)
	{
		$this->page_attributes->breadcrumb 			= [];

		//generate view
		$this->page_attributes->subtitle 			= 'Fashionable and Modern Batik';
		$this->page_attributes->data				= 	[
															'header'	=> $header,
															'msg' 		=> $msg
														];
		$this->page_attributes->controller_name		= $this->controller_name;
		$this->page_attributes->metas 				= 	[
															'og:type' 			=> 'website', 
															'og:title' 			=> 'BALIN.ID', 
															'og:description' 	=> 'Fashionable and Modern Batik',
															'og:url' 			=> $this->balin['info']['url']['value'],
															'og:image' 			=> $this->balin['info']['logo']['value'],
															'og:site_name' 		=> 'balin.id',
															'fb:app_id' 		=> Config::get('fb_app.id'),
														];
		$this->page_attributes->source 				=  $this->page_attributes->source . '404';

		return $this->generateView();
	}
}
