<?php

class AccountController extends \BaseController {

public function publicView($id)
{
	$user = Auth::user();
	$host_path = Config::get('app.host_path');
	// $my_connections = Connection::where('to','=',$user->id)
	// 	->orWhere('from','=',$user->id)
	// 	->where('accept','=',true)->get();
	$userview = User::find($id);
	if($userview == null)
	{
		return Response::json(array('status'=>'failed','message'=>'user does not exist!','err_code'=>1));
	}
	// $con_member_id_list = array();
	// foreach ($my_connections as $con)
	// {
	// 	if($con->from == $user->id)
	// 		$con_member_id_list[] = $con->to;
	// 	else
	// 		$con_member_id_list[] = $con->from;
	// }
	$connection_count = Connection::where('to','=',$userview->id)
	 	->orWhere('from','=',$userview->id)
	 	->where('accept','=',true)
	 	->count();
	$endorsement_Count = Endorsement::where('to_user','=',$userview->id)
	 	->count();
	//if(in_array($userview->id, $con_member_id_list) || $id = $user->id)
	//{
		$user_details = array('id'=>$userview->id,
		'name'=>$userview->name,
		'email'=>$userview->email,
	    'mobile'=>$userview->mobile,
		'chamber_profile'=>$userview->chamber_profile,
		'connection_count'=>$connection_count,
		'endorsement_count'=>$endorsement_Count);
		if($userview->profile != null)
		{
			$company_details = array('profile_id'=>$userview->profile->id,
	    	    'company_name'=>$userview->profile->company_name,
	    	    'profile_id'=>$userview->profile->id,
	    	    'designation'=>$userview->profile->designation,
	    	    'company_email'=>$userview->profile->company_email,
	    		'membership_number'=>$userview->profile->membership_number,
	    		'trade_license_number'=>$userview->profile->trade_license_number,
	    		'verified'=>$userview->profile->verified,
	    		'image'=>$userview->profile->image);
	    	if($userview->profile->image != null )
	    		$company_details['image'] = $host_path.$userview->profile->image;
		}
		else
		{
			$company_details = array();
		}
		
	    $response = array('connected'=>1, 'user'=>$user_details, 'company_profile'=>$company_details);
	//}
	// else
	// {
	// 	$user_details = array('id'=>$userview->id,
	// 	 'name'=>$userview->name,
	// 	 'chamber_profile'=>$userview->chamber_profile,
	// 	 'email'=>$userview->email,
	//      'mobile'=>$userview->mobile,
	// 	 );
	// 	if($userview->profile != null)
	// 	{
	// 		$company_details = array('profile_id'=>$userview->profile->id,
	// 			//add endorsed no: also
	// 	    	    'profile_id'=>$userview->profile->id,
	// 	    	    'company_name'=>$userview->profile->company_name,
	// 	    	    'designation'=>$userview->profile->designation,
	// 	    		'trade_license_number'=>$userview->profile->trade_license_number,
	// 	    		'verified'=>$userview->profile->verified,
	// 	    		'image'=>$userview->profile->image);
	// 	    if($userview->profile->image != null )
	// 	    	$company_details['image'] = $host_path.$userview->profile->image;
	//     }
	// 	else
	// 	{
	// 		$company_details = array();
	// 	}
	//     $response = array('connected'=>1, 'user'=>$user_details, 'company_profile'=>$company_details);
	// }
	return Response::json($response);
}

public function signUp()
{
	$rules = array(
		    'name'     => 'required',
		    'username' => 'required|alphaNum|unique:users',
			'email'    => 'required|email|unique:users', // make sure the email is an actual email
			'password' => 'required|min:3', // password can only be alphanumeric and has to be greater than 3 characters
			'mobile'   => 'required|integer',
			'device_token'   => 'alphaNum',
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
			if(strlen(Input::get('device_token'))>5)
			{
				$user->deviceToken   = Input::get('device_token');
			}

			$user->save();
			return Response::json(array('status'=>'success'));
		}

}

public function login()
{
	$rules = array(
			'username'  => 'required|alphaNum',
			'password'  => 'required|min:3',
			'device_token'   => 'alphaNum',
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
    			if($user->active == 0)
    			{
    				return Response::json(array('errors' => 'This account is deactivated','status'=>'failed'));
    			}
    			if($user->deviceToken!=Input::get('device_token') && strlen(Input::get('device_token'))>5)
					{
						$user->deviceToken   = Input::get('device_token');
						$user->save();
					}

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
					if(strlen(Input::get('device_token'))>5)
					{
						$user->deviceToken   = Input::get('device_token');
					}
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
			if($user->profile!=null)
			{
				$company_profile = $user->profile;
				$profile_complete = 1;
			}
				
			else
			{
				$company_profile = array();
				$profile_complete = 0;
			}
			return Response::json(array('status'=>'success','user'=>$user, 'token'=>$publicToken,
			'profile_complete'=> $profile_complete ));
			}
	}

	public function doLogout()
	{
		Auth::logout(); // log the user out of our application
		return Redirect::to('login'); // redirect the user to the login screen
	}


}
