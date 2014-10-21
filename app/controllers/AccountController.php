<?php

class AccountController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
		public function showLogin()
	{
		// show the form
		return View::make('login');
	}

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
			// $userdata = array(
			// 'name'     => Input::get('name' ),
		 	// 'username' => Input::get('username'),
			// 'email'    => Input::get('email'),
			// 'password' => Input::get('password'),
			// 'mobile'   => Input::get('mobile'),
			// );
			//User::create($userdata);
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



	public function doLogin()
	{
		// validate the info, create rules for the inputs
		$rules = array(
			'email'    => 'required|email', // make sure the email is an actual email
			'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
			return Redirect::to('login')
				->withErrors($validator) // send back all errors to the login form
				->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		} else {

			// create our user data for the authentication
			$userdata = array(
				'email' 	=> Input::get('email'),
				'password' 	=> Input::get('password')
			);

			// attempt to do the login
			if (Auth::attempt($userdata)) {
				// validation successful!
				// redirect them to the secure section or whatever
				// return Redirect::to('secure');
				// for now we'll just echo success (even though echoing in a controller is bad)
				echo 'SUCCESS!';

			} else {	 	

				// validation not successful, send back to form	
				return Redirect::to('login');

			}

		}
	}

	public function doLogout()
	{
		Auth::logout(); // log the user out of our application
		return Redirect::to('login'); // redirect the user to the login screen
	}

	public function index()
	{
		//
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
