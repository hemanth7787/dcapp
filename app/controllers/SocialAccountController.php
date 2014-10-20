<?php

class SocialAccountController extends \BaseController {

	public function signUp()
	{
	$rules = array(
		    'name'     => 'required|alphaNum',
		    //'username' => 'required|alphaNum|unique:users',
			'email'    => 'required|email|unique:users', // make sure the email is an actual email
			//'password' => 'required|alphaNum|min:3', // password can only be alphanumeric and has to be greater than 3 characters
			'mobile'   => 'required|integer',

			'social_id' => 'required|alphaNum|unique:social_accounts',
			'token'   	=> 'required|alphaNum',
			'provider' 	=> 'required|alphaNum',
			'extra_data'=> 'alphaNum',

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
			$user->username = Input::get('social_id');
			$user->email    = Input::get('email');
			//random password
			$user->password = Hash::make(bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)));
			$user->mobile   = Input::get('mobile');
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
			'token'   	=> 'required|alphaNum',
			'provider' 	=> 'required|alphaNum',
		);
	$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else{
			/*
			***************************************
    GET USER WITH SOCIAL ID
    ***************************************
    */
	//$user = User::find(1);
	//$count = User::where('votes', '>', 100)
	$social = SocialAccount::where('provider','=',Input::get('provider'))->where('social_id', '=', Input::get('social_id' ))->first();
	
	$user   = $social->user;
	//return var_dump($user) ;
	Auth::login($user);
	//$ur = Auth::user();
	//return var_dump($ur);
	if(Auth::check()) {

/* 	***************************************
	VALIDATE SOCIAL TOKEN CORRECTNESS AGAINST SOCIAL_ID
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
