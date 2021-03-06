<?php

class AdminController extends \BaseController {

	// public function userManagementIndex()
	// {
	// 	$data = User::all();
	// 	return View::make('admin.usermgmt')->withData($data);
	// }

	// public function userManagementShow($id)
	// {
	// 	$userdata = User::find($id);
	// 	$companydata = $userdata->profile;
	// 	return View::make('admin.users.userShow')->with('userdata',$userdata)
	// 	->with('companydata',$companydata); //->withData($data);
	// }


	// public function userManagementEdit($id)
	// {
	// 	$rules = array(
	// 	    'active'     => 'required|boolean',
	// 	    'verified'  => 'required|boolean',
	// 	    'superuser'  => 'required|boolean',
	// 	);
	// 	$validator = Validator::make(Input::all(), $rules);
	// 	if ($validator->fails()) {
	// 			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
	// 	}
	// 	else
	// 	{
	// 		$user = User::find($id);
	// 		// $profile = $userdata->profile;
	// 		$user->active = Input::get('active');
	// 		$user->superuser = Input::get('superuser');
	// 		$user->save();

	// 		$profile = $user->profile;
	// 		$profile->verified = Input::get('verified');
	// 		$profile->save();
	// 		return Response::json(array('status'=>'success'));
	// 	}


		
		
		
	// }

	public function logout()
	{
		Auth::logout();
    	return Redirect::to('admin/login');
	}

	public function index()
	{
		$data = 'test';
		return View::make('admin.index')->withData($data);
		//return View::make('view.name', $data);
	}

	public function loginIndex()
	{
		$data = 'test';
		return View::make('admin.login')->withData($data);
		//return View::make('view.name', $data);
	}

	public function loginPost()
	{

		$rules = array(
		    'username'  => 'required',
		    'password'  => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
				return View::make('admin.login')
                  ->with('errors', $validator->messages());
		}
		else{

		$userdata = array(
            'username' => Input::get('username'),
            'password' => Input::get('password'),
            'active' => 1,
            'superuser' => 1,
        );
        //Auth::attempt(array('email' => $email, 'password' => $password), true)
  //       if(Input::get('persist') == 'on')
		//    $isAuth = Auth::attempt($userdata, true);
		// else
		//    $isAuth = Auth::attempt($userdata);
 
        /* Try to authenticate the credentials */
        if(Auth::attempt($userdata)) 
        {
            // we are now logged in, go to admin
            // return Redirect::to('admin');
            // Session::put('current_user_id', $user_id);
            return Redirect::to('admin');
            //return View::make('admin.index');
        }
        else
        {
            $general_error = 'Bad username or password';
            return View::make('admin.login')
            //return Redirect::to('admin/login')
            ->with('general_error', $general_error );
        }
    }







		//return View::make('admin.index')->withData($data);}
		//return View::make('view.name', $data);}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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


}
