<?php namespace App\Http\Controllers\Me;

use App\API\Connectors\APIUser;
use App\API\Connectors\APISendMail;

use App\Http\Controllers\BaseController;

use Input, Redirect, Session, Validator;

use Illuminate\Support\MessageBag;

/**
 * Used Invitation Redeem Controller
 * 
 * @author agil
 */
class InvitationController extends BaseController 
{
	protected $controller_name 						= 'invitation';

	public function __construct()
	{
		parent::__construct();

		Session::set('API_token', Session::get('API_token_private'));

		$this->page_attributes->title 				= 'BALIN.ID';
		$this->page_attributes->source 				= 'web_v2.pages.invitation.';
		$this->page_attributes->breadcrumb			=	[
															'Who Got My Invitation' 	=> route('my.balin.invitation.index'),
														];
	}

	/**
	 * function to generate view invitation for me
	 *
	 * @return view
	 */
	public function index()
	{		
		$APIUser 									= new APIUser;

		$me_detail 									= $APIUser->getMeDetail([
															'user_id' 	=> Session::get('whoami')['id'],
														]);

		//Get My invitation
		$me_invitation 								= $APIUser->getMeInvited(['user_id' 	=> Session::get('whoami')['id']]);

		$this->page_attributes->data				= 	[
															'me' 			=> $me_detail,
															'invitations'	=> $me_invitation['data'],
														];

		$this->page_attributes->subtitle 			= 'Who Got My Invitation';
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb);
		$page 										= View('web_v2.pages.profile.invitation.index')
														->with('data', $this->page_attributes->data);

		return $page;
	}

	/**
	 * function to modal show input invitation for others
	 *
	 */
	public function create()
	{											
		$page 										= view('web_v2.pages.profile.invitation.create');

		return $page;
	}
	
	/**
	 * function to store invitation for others
	 *
	 * @param referral_code
	 */
	public function store()
	{
		/* get for redirect route to */
		$APIUser 									= new APIUser;

		$whoami 									= $APIUser->getMeDetail([
															'user_id' 	=> Session::get('whoami')['id'],
														]);

		$invitations 								= [];
		$emails 									= explode(',', Input::get('emails'));

		$rules 										= ['email' => 'required|email|max:255'];

		foreach ($emails as $key => $value) 
		{
			$invitation['email']					= trim($value);

			$validator 								= Validator::make($invitation, $rules);
			
			if(!$validator->passes())
			{
				$this->errors						= ['Email "'.$invitation['email'].'" tidak sah'];
				Session::put('error_invite', '1');

				return $this->generateRedirectRoute('my.balin.redeem.index');	
			}

			$invitations[]							= $invitation['email'];

		}

		/* array parameter to API */
		$data										= 	[
															'user_id'		=> Session::get('whoami')['id'],
															'invitations'	=> $emails,
														];

		$result										= $APIUser->postMeInvitation($data);

		if (isset($result['message']))
		{
			$this->errors							= $result['message'];
			Session::put('error_invite', '1');
		}
		else
		{
			// $infos 								= [];
			// foreach ($this->balin['info'] as $key => $value) 
			// {
			// 	$infos[$value['type']]			= $value['value'];
			// }

			// $infos['action']					= route( env('ROUTE_BALIN_INVITATION_GET'), $whoami['data']['code_referral']);

			// $mail 								= new APISendMail;
			// $result								= $mail->invitation($whoami['data'], $emails, $infos);
			
			// if (isset($result['message']))
			// {
			// 	$this->errors					= $result['message'];
			// }

			$this->page_attributes->success 	= 'Anda telah mengirimkan  '.count($emails).' undangan kepada teman Anda';
			Session::forget('error_invite');
		}

		return $this->generateRedirectRoute('my.balin.redeem.index');	
	}
}