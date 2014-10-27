<?php

class BusinessListingController extends \BaseController {

	public function dummyGetlist()
	{
		$companyProfiles = CompanyProfile::groupBy('trade_license_number')->get();

		$p_list = array();
		foreach ($companyProfiles as $profile)
	    {
	    	array_push($p_list, array('id'=>$profile->id,
	    		'company_name'=>$profile->company_name,
	    		'trade_license_number'=>$profile->trade_license_number));
	        //$p_list[] = array(...);
	    }
	    return Response::json($p_list);

	}

	public function dummyFilteredMemberlist($trade_license_number)
	{
		$companyProfiles = CompanyProfile::where('trade_license_number','=',$trade_license_number)->get();


		$p_list = array();
		foreach ($companyProfiles as $profile)
	    {
	    	// TODO #################################
	    	// Check if users has connection ??


	    	$user_details = array('id'=>$profile->user->id,
	    		'name'=>$profile->user->name,
	    		'email'=>$profile->user->email,
	    		'mobile'=>$profile->user->mobile,
	    		'chamber_profile'=>$profile->user->chamber_profile);

	    	$profile_details = array('id'=>$profile->id,
	    	    'company_name'=>$profile->company_name,
	    		'designation'=>$profile->designation,
	    		'company_email'=>$profile->company_email,
	    		'membership_number'=>$profile->membership_number,
	    		'trade_license_number'=>$profile->trade_license_number,
	    		'verified'=>$profile->verified,
	    		'image'=>$profile->image);

	    	array_push($p_list, array('company_profile'=>$profile_details,'user'=>$user_details));
	        //$p_list[] = array(...);
	    }
	    return Response::json($p_list);

	}

}
