<?php namespace App\Http\Controllers\Web\Campaign;

use App\Http\Controllers\Web\Controller;

use Input, Redirect, Auth, Carbon, Validator, DB, App;
use Illuminate\Support\MessageBag;

// use App\Models\User;
// use App\Models\PointLog;
// use App\Models\StoreSetting;

class InvitationController extends Controller 
{
	protected $controller_name 					= 'join';

	public function __construct()
	{
		parent::__construct();
	}
	
	public function getinvitation()
	{	
		// if (Auth::check())
		// {
		// 	return Redirect::route('frontend.user.index');
		// }

		$breadcrumb										= ['Sign In By Invitation' => route('balin.campaign.join.get')];
		$this->layout->page 							= view('web.page.campaign.index')
																->with('controller_name', $this->controller_name)
																->with('breadcrumb', $breadcrumb);

		$this->layout->controller_name			= $this->controller_name;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Sign In By Invitation';

		return $this->layout;
	}

	public function postinvitation($id = null)
	{
		
	}
}