<?php

class CompanyProfileController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{
		$user = Auth::user();
		//$profile = User::find(1)->company_profile;
		$profile = $user->profile?: new CompanyProfile;
		$profile->user_id = $user->id;
		$profile->save();
		//$profile = $user->company_profile ?: new CompanyProfile;
		//$profile = CompanyProfile::find(1)->user; //->company_profile;
		//return var_dump($profile);
		return Response::json($profile);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
			$rules = array(
		    'user_id'       => 'required|integer|exists:users,id',
		    'company_name'  => 'required|alphaNum',
		    'designation'   => 'required|alphaNum',
			'company_email' => 'required|email', 
			'membership_number'      => 'required|alphaNum',
			'trade_license_number'   => 'required|alphaNum',

		);
	$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else{

			// also validate user profile belons to current user
			if(Auth::user()->id != Input::get('user_id'))
			{
				return Response::json(array('errors' => 'Insufficient privilege edit this profile',
					'status'=>'failed'));
			}

			// changed this to get first or create
			// $profile = new CompanyProfile();
			$profile = CompanyProfile::firstOrCreate(array('id' => Input::get('user_id')));

			$profile->user_id	= Input::get('user_id');
			$profile->company_name = Input::get('company_name');
			$profile->designation  = Input::get('designation');
			$profile->company_email = Input::get('company_email');
			$profile->membership_number = Input::get('membership_number');
			$profile->trade_license_number = Input::get('trade_license_number');

			$profile->save();
			return Response::json(array('status'=>'success'));
		}
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
