<?php

class SocialAccountController extends \BaseController {

	public function signUp()
	{
	$rules = array(
		    'name'     => 'required',
		    //'username' => 'required|alphaNum|unique:users',
			'email'    => 'required|email|unique:users', // make sure the email is an actual email
			//'password' => 'required|alphaNum|min:3', // password can only be alphanumeric and has to be greater than 3 characters
			'mobile'   => 'required|integer',

			'social_id' => 'required|alphaNum|unique:social_accounts',
			'token'   	=> 'required',
			'provider' 	=> 'required|alphaNum',
			'device_token'   => 'alphaNum',
			//'extra_data'=> 'alphaNum',

		);
	$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else{
		/* 	
		***************************************
		VALIDATE SOCIAL TOKEN CORRECTNESS AGAINST SOCIAL_ID
		***************************************
		*/

			$user = new User();
			$user->name     = Input::get('name' );
			// this may be long
			$user->username = Input::get('social_id');
			$user->email    = Input::get('email');
			//random password
			$user->password = Hash::make(bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)));
			$user->mobile   = Input::get('mobile');
			if(strlen(Input::get('device_token'))>5)
			{
				$user->deviceToken   = Input::get('device_token');
			}
			$user->save();

			$social = new SocialAccount();
			$social->user_id   = $user->id;
			$social->social_id = Input::get('social_id' );
			$social->token     = Input::get('token' );
			$social->provider  = Input::get('provider');
			$social->extra_data = Input::get('extra_data' );
			$social->save();

			Auth::login($user);
			$authToken = AuthToken::create(Auth::user());
			$publicToken = AuthToken::publicToken($authToken);
			return Response::json(array('status'=>'success','user'=>$user,
				'token'=>$publicToken));
		}
}
	public function login()
	{
			$rules = array(
			'social_id' => 'required|alphaNum',
			'token'   	=> 'required',
			'provider' 	=> 'required|alphaNum',
			'device_token'   => 'alphaNum',
		);
	$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
	else
	{

		$social = SocialAccount::where('provider','=',Input::get('provider'))->where('social_id', '=', Input::get('social_id' ))->first();
		if($social == null)
			return Response::json(array('errors' => "specifed account does not exist!",'status'=>'failed'));
		$user   = $social->user;
		if($user->active == 0)
    			{
    				return Response::json(array('errors' => 'This account is deactivated','status'=>'failed'));
    			}
		if($user->deviceToken!=Input::get('device_token') && strlen(Input::get('device_token'))>5)
		{
			$user->deviceToken   = Input::get('device_token');
			$user->save();
		}
		Auth::login($user);
		if(Auth::check()) {

	/* 	***************************************
		TODO VALIDATE SOCIAL TOKEN CORRECTNESS AGAINST SOCIAL_ID
		***************************************
	*/

	 	$authToken = AuthToken::create(Auth::user());
		$publicToken = AuthToken::publicToken($authToken);
		//return var_dump($publicToken);
		return Response::json(array('status'=>'success','user'=>$user,
			'token'=>$publicToken ));
		}
	}



	}

}
