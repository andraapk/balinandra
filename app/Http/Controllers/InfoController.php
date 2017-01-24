<?php namespace App\Http\Controllers;

use Input, Config, Session;
use App\API\Connectors\APISendMail;

/**
 * Used for page info of balin
 * 
 * @author cmooy
 */
class InfoController extends BaseController 
{	
	protected $controller_name 						= 'info';

	function __construct()
	{
		parent::__construct();

		Session::set('API_token', Session::get('API_token_public'));

		$this->page_attributes->title 				= 'BALIN.ID';
		$this->page_attributes->source 				= '.info.';
		$this->page_attributes->breadcrumb			=	[
														];
	}

	/**
	 * display about us
	 *
	 * @return view
	 */
	public function info($type)
	{
		//1. generate breadcrumb
		switch (strtolower($type)) 
		{
			case 'about-us':
				$content 							= $this->balin['about_us']['value'];
				$breadcrumb							= 	[
															'About Us' 	=> route('balin.info.index', ['type' => 'about-us']),
														];
				break;
			case 'terms-conditions':
				$content 							= $this->balin['term_and_condition']['value'];
				$breadcrumb							= 	[
															'Terms & Conditions' 	=> route('balin.info.index', ['type' => 'terms-conditions']),
														];
				break;
			case 'why-join':
				$content 							= $this->balin['why_join']['value'];
				$breadcrumb							= 	[
															'BALIN Point' 	=> route('balin.info.index', ['type' => 'why-join']),
														];
				break;
			default:
				\App::abort();
				break;
		}


		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//2. generate view
		$this->page_attributes->subtitle 			= 'Fashionable and Modern Batik';
		$this->page_attributes->metas 				= 	[
															'og:type' 			=> 'website', 
															'og:title' 			=> 'BALIN.ID', 
															'og:description' 	=> 'Fashionable and Modern Batik',
															'og:url' 			=> $this->balin['info']['url']['value'],
															'og:image' 			=> $this->balin['info']['logo']['value'],
															'og:site_name' 		=> 'balin.id',
															'fb:app_id' 		=> Config::get('fb_app.id'),
														];
		
		$this->page_attributes->data				= 	['content' => $content, 'type' => $type];
		$this->page_attributes->source 				=  $this->page_attributes->source . 'index';
		$this->base_path_view 						= 'web_v2.pages';

		return $this->generateView();
	}

	/**
	 * display contact us
	 *
	 * @return view
	 */
	public function contactus()
	{
		//1. generate breadcrumb
		$breadcrumb									= 	[
															'Contact Us' 	=> route('balin.contact.us'),
														];

		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//2. generate view
		$this->page_attributes->subtitle 			= 'Fashionable and Modern Batik';
		$this->page_attributes->data				= 	[];
		$this->page_attributes->metas 			= 	[
														'og:type' 			=> 'website', 
														'og:title' 			=> 'BALIN.ID', 
														'og:description' 	=> 'Fashionable and Modern Batik',
														'og:url' 			=> $this->balin['info']['url']['value'],
														'og:image' 			=> $this->balin['info']['logo']['value'],
														'og:site_name' 		=> 'balin.id',
														'fb:app_id' 		=> Config::get('fb_app.id'),
													];
		$this->page_attributes->source 				=  $this->page_attributes->source . 'contact_us';
		$this->base_path_view 						= 'web_v2.pages';

		return $this->generateView();
	}

	/**
	 * store contact us
	 *
	 * @return view
	 */
	public function emailus()
	{
		//1. Get input detail
		$customer 							= Input::only('message', 'name', 'email');
		
		//2. Post contact mail
		$infos 								= [];
		foreach ($this->balin['info'] as $key => $value) 
		{
			$infos[$value['type']]			= $value['value'];
		}

		$mail 								= new APISendMail;
		$result								= $mail->contact($customer, $infos);
		
		if (isset($result['message']))
		{
			$this->errors					= $result['message'];
		}

		$this->page_attributes->success 		= "Pesan Anda sudah disampaikan pada customer service kami.";

		return $this->generateRedirectRoute('balin.contact.us');
	}
}