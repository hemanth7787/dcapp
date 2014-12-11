<?php

class AdminUsersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = User::with('profile');
		$profiles = CompanyProfile::all();

		if(Input::get('superuser')!=null && Input::get('superuser')!=2)
			$data = $data->where('superuser',Input::get('superuser'));

		if(Input::get('active')!=null && Input::get('active')!=2)
			$data = $data->where('active',Input::get('active'));

		if(Input::get('company')!=null && Input::get('company')!=0)
			{
				$tl_no = $profiles->find(Input::get('company'))
				->trade_license_number;

				// "USE" used to add extra variable to fuction
				$filtered_profile_ids = $profiles->filter(function($item) use ($tl_no)
				{
				    return ($item->trade_license_number == $tl_no);

				})->values()->lists('user_id');


				$data = $data->find($filtered_profile_ids);
			}
		else 
			{
				$data = $data->get();
			}


		// QUERY  again  .. bad :(
		$company_list = CompanyProfile::groupBy('trade_license_number')
		->lists('company_name','id');


		// QUERY MISER
		// $unique_array = array(0);
		// // Reference of the unique array is passed since we want to modify
		// //the original variable instead of a copy.
		// $company_list = $profiles->filter(function($item) use (&$unique_array)
		// {
		// 	if(!in_array($item->trade_license_number, $unique_array))
		// 	{
		// 		array_push($unique_array,$item->trade_license_number);
		// 		return true;
		// 	}
		// })->values()->lists('company_name','id');

		return View::make('admin.users.index')
		->withData($data)
		->with('company_list',$company_list)
		->with('default_company_filter',Input::get('company'))
		->with('default_user_type_filter',Input::get('superuser'))
		->with('default_user_status_filter',Input::get('active'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.users.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
		    'name'     => 'required',
		    'username' => 'required|alphaNum|unique:users',
			'email'    => 'required|email|unique:users', // make sure the email is an actual email
			'password' => 'required|min:3', // password can only be alphanumeric and has to be greater than 3 characters
			'password_again'   => 'required|same:password',
			'mobile'   => 'required|integer',
			// 'device_token'   => 'alphaNum',
			'company_name'  => 'required|alphaNum',
		    'designation'   => 'required|alphaNum',
			'company_email' => 'required|email', 
			// 'membership_number'      => 'required|alphaNum',
			'trade_license_number'   => 'required|alphaNum',
			'profile_image'		     => 'image',
		);
		$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
				Session::flash('message', 'Please correct the errors below!'); 
				Session::flash('message_type', 'danger');
				Input::flash(); // wierd method of sending old form data to the view
				return View::make('admin.users.create')
                ->with('errors', $validator->messages());
                // ->withInput(Input::all())
		}
		else
		{
			$user = new User();

			$user->name     = Input::get('name' );
			$user->username = Input::get('username');
			$user->email    = Input::get('email');
			$user->password = Hash::make(Input::get('password'));
			$user->mobile   = Input::get('mobile');
			// if(strlen(Input::get('device_token'))>5)
			// {
			// 	$user->deviceToken   = Input::get('device_token');
			// }
			$user->save();

			$profile = CompanyProfile::firstOrCreate(array('user_id' => $user->id));
			//$profile->user_id	= Input::get('user_id');
			$profile->company_name = Input::get('company_name');
			$profile->designation  = Input::get('designation');
			$profile->company_email = Input::get('company_email');
			// $profile->membership_number = Input::get('membership_number');
			$profile->trade_license_number = Input::get('trade_license_number');
			// $profile->image = Input::file('image');

			if(Input::file('image')!= null)
			{
				$image = Input::file('image');
				$filename      = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)).'-'.time(). '.' . $image->getClientOriginalExtension();
				$relative_path = 'images/profile/' . $filename;
				$path = public_path($relative_path);
				Image::make($image->getRealPath())->save($path);
				$profile->image = $relative_path;
			}
			$profile->save();

			return Redirect::to('admin/users')
			->with('message', 'User created successfully')
			->with('message_type', 'success');
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$userdata = User::find($id);
		$profile = CompanyProfile::firstOrCreate(array('user_id' => $userdata->id));

		return View::make('admin.users.show')
		->with('userdata',$userdata)
		->with('companydata',$profile);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$userdata = User::find($id);
		$profile = CompanyProfile::firstOrCreate(array('user_id' => $userdata->id));

		return View::make('admin.users.edit')
		->with('userdata',$userdata)
		->with('companydata',$profile);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = User::find($id);
		$profile = CompanyProfile::firstOrCreate(array('user_id' => $user->id));
		$rules = array(
		    'name'     => 'required',
		    // 'username' => 'required|alphaNum|unique:users',
			'email'    => 'required|email', // make sure the email is an actual email
			'password' => 'required_with:reset|min:3', // password can only be alphanumeric and has to be greater than 3 characters
			'password_again'   => 'equired_with:reset|same:password',
			'mobile'   => 'required|integer',
			// 'device_token'   => 'alphaNum',
			'company_name'  => 'required',
		    'designation'   => 'required',
			'company_email' => 'required|email', 
			// 'membership_number'      => 'required|alphaNum',
			'trade_license_number'   => 'required|alphaNum',
			'profile_image'		     => 'image',
		);
		$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
				Session::flash('message', 'Please correct the errors below!'); 
				Session::flash('message_type', 'danger');
				Input::flash(); // wierd method of sending old form data to the view
				return View::make('admin.users.edit')
                ->with('errors', $validator->messages())
                ->with('userdata',$user)
				->with('companydata',$profile);
		}
		else
		{
			

			$user->name     = Input::get('name' );
			// $user->username = Input::get('username');
			$user->email    = Input::get('email');
			if(Input::get('reset_pwd' )=="on")
			{
				$user->password = Hash::make(Input::get('password'));
			}
			$user->mobile   = Input::get('mobile');
			// if(strlen(Input::get('device_token'))>5)
			// {
			// 	$user->deviceToken   = Input::get('device_token');
			// }
			$user->save();

			$profile = CompanyProfile::firstOrCreate(array('user_id' => $user->id));
			//$profile->user_id	= Input::get('user_id');
			$profile->company_name = Input::get('company_name');
			$profile->designation  = Input::get('designation');
			$profile->company_email = Input::get('company_email');
			// $profile->membership_number = Input::get('membership_number');
			$profile->trade_license_number = Input::get('trade_license_number');
			// $profile->image = Input::file('image');

			if(Input::file('image')!= null)
			{
				$image = Input::file('image');
				$filename      = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)).'-'.time(). '.' . $image->getClientOriginalExtension();
				$relative_path = 'images/profile/' . $filename;
				$path = public_path($relative_path);
				Image::make($image->getRealPath())->save($path);
				$profile->image = $relative_path;
			}
			$profile->save();

			return Redirect::to('admin/users/'.$user->id)
			->with('message', 'Successfully Edited')
			->with('message_type', 'success');
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


	public function AjaxEditOperations($id)
	{
		$rules = array(
		    'active'     => 'required|boolean',
		    'verified'  => 'required|boolean',
		    'superuser'  => 'required|boolean',
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
				return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			$user = User::find($id);
			// $profile = $userdata->profile;
			$user->active = Input::get('active');
			$user->superuser = Input::get('superuser');
			$user->save();

			$profile = $user->profile;
			$profile->verified = Input::get('verified');
			$profile->save();
			return Response::json(array('status'=>'success'));
		}

	}


}
