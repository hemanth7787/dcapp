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
		$userdata = User::find($id);
		$companydata = $userdata->profile;

		return View::make('admin.users.show')
		->with('userdata',$userdata)
		->with('companydata',$companydata);
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
