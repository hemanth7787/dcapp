<?php

class AccountController extends \BaseController {

public function signUp()
{
	$rules = array(
		    'name'     => 'required',
		    'username' => 'required|alphaNum|unique:users',
			'email'    => 'required|email|unique:users', // make sure the email is an actual email
			'password' => 'required|min:3', // password can only be alphanumeric and has to be greater than 3 characters
			'mobile'   => 'required|integer',
		);
	$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else{
			$user = new User();

			$user->name     = Input::get('name' );
			$user->username = Input::get('username');
			$user->email    = Input::get('email');
			$user->password = Hash::make(Input::get('password'));
			$user->mobile   = Input::get('mobile');

			$user->save();
			return Response::json(array('status'=>'success'));
		}

}

public function login()
{
	$rules = array(
			'username'  => 'required|alphaNum',
			'password'  => 'required|min:3',
		);
	$validator = Validator::make(Input::all(), $rules);
	if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
	else
		{
		$username = Input::get('username');
		$password = Input::get('password');

		if (Auth::attempt(array('username' => $username, 'password' => $password)))
			{
    			$user   = Auth::user();
			}
		else
			{
				$client = new SoapClient("http://dcwebapps.dubaichamber.com:8080/dcciws/services/Dcmobws?wsdl");
    			$params = array (
    			"userName" => $username,
    			"password" => $password,
    			);
				$response = $client->__soapCall('authWithProfile', $params);
				$parser = simplexml_load_string($response);

				if($parser->ROW->MEMBER_NO)
				{
					// will have a problem if uname is already registered in app db 
					//and valid user from chamber try to login

					$user   = new User();

					$user->name     = $parser->ROW->MEMBER_NAME_EN;
					$user->username = $username;
					$user->email    = $parser->ROW->EMAIL_ADDR;
					$user->password = Hash::make($password);
					$user->mobile   = $parser->ROW->PHONE;
					$user->chamber_profile = true;
					$user->save();

					$dccom_profile = new DccomProfile();
					$dccom_profile->user_id   = $user->id;
					$dccom_profile->MEMBER_NO = (int)($parser->ROW->MEMBER_NO);
					$dccom_profile->MEMBER_NAME_EN = $parser->ROW->MEMBER_NAME_EN;
					$dccom_profile->MEMBER_NAME_AR = $parser->ROW->MEMBER_NAME_AR;
					$dccom_profile->MEMBER_TYPE    = $parser->ROW->MEMBER_TYPE;
					$dccom_profile->MEMBER_STATUS  = $parser->ROW->MEMBER_STATUS;
					$dccom_profile->ADDRESS1 = $parser->ROW->ADDRESS1;
					$dccom_profile->PO_BOX   = $parser->ROW->PO_BOX;
					$dccom_profile->CITY     = $parser->ROW->CITY;
					$dccom_profile->AREA   = $parser->ROW->AREA;
					$dccom_profile->STREET = $parser->ROW->STREET;
					$dccom_profile->PHONE  = $parser->ROW->PHONE;
					$dccom_profile->CONTACT_NAME = $parser->ROW->CONTACT_NAME;
					$dccom_profile->LOGIN      = $parser->ROW->LOGIN;
					$dccom_profile->EMAIL_ADDR = $parser->ROW->EMAIL_ADDR;
					$dccom_profile->X_MEMBER_EXPIRY_DT = $parser->ROW->X_MEMBER_EXPIRY_DT;

					$dccom_profile->save();

					Auth::attempt(array('username' => $username, 'password' => $password));
					$user   = Auth::user();

					}
				else
				{
					return Response::json(array('error' => 'Not Authorized', 'status'=>'failed'));
					}
			}
			$authToken = AuthToken::create($user);
			$publicToken = AuthToken::publicToken($authToken);
			return Response::json(array('status'=>'success','user'=>$user, 'token'=>$publicToken ));
			}
	}

	public function doLogout()
	{
		Auth::logout(); // log the user out of our application
		return Redirect::to('login'); // redirect the user to the login screen
	}


}
