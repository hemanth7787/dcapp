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

	public function dummyFilteredMemberlist($trade_license_number=null)
	{
		$companyProfiles = CompanyProfile::where('trade_license_number','=',$trade_license_number)->get();
		$p_list = array();
		$user = Auth::user();
		$my_connections = Connection::where('to','=',$user->id)
			->orWhere('from','=',$user->id)
			->where('accept','=',true)->get();

		$con_member_id_list = array();
		foreach ($my_connections as $con)
		{
			if($con->from == $user->id)
				$con_member_id_list[] = $con->to;
			else
				$con_member_id_list[] = $con->from;

		}

		$host_path = Config::get('app.host_path');
		foreach ($companyProfiles as $profile)
	    {
	    	// show detailed profile only for connections
			if(in_array($profile->user->id, $con_member_id_list))
			{
			$connection = 1;

		    $user_details = array('id'=>$profile->user->id,
	    		'name'=>$profile->user->name,
	    		'email'=>$profile->user->email,
	    		'mobile'=>$profile->user->mobile,
	    		'chamber_profile'=>$profile->user->chamber_profile,
	    		'connected'=>$connection
	    		);

	    	$profile_details = array('id'=>$profile->id,
	    	    'company_name'=>$profile->company_name,
	    		'designation'=>$profile->designation,
	    		'company_email'=>$profile->company_email,
	    		'membership_number'=>$profile->membership_number,
	    		'trade_license_number'=>$profile->trade_license_number,
	    		'verified'=>$profile->verified,
	    		'image'=>$profile->image);

	    	if($profile->image != null )
	    	$profile_details['image'] = $host_path.$profile->image;
			}
			else
			{
				$connection = 0;
	    		$user_details = array('id'=>$profile->user->id,
	    		'name'=>$profile->user->name,
	    		//'email'=>$profile->user->email,
	    		//'mobile'=>$profile->user->mobile,
	    		'chamber_profile'=>$profile->user->chamber_profile,
	    		'connected'=>$connection
	    		);

	    	$profile_details = array('id'=>$profile->id,
	    	    'company_name'=>$profile->company_name,
	    		'designation'=>$profile->designation,
	    		//'company_email'=>$profile->company_email,
	    		//'membership_number'=>$profile->membership_number,
	    		'trade_license_number'=>$profile->trade_license_number,
	    		'verified'=>$profile->verified,
	    		'image'=>$profile->image);
	    	if($profile->image != null )
	    	$profile_details['image'] = $host_path.$profile->image;
			}

	    	array_push($p_list, array('company_profile'=>$profile_details,'user'=>$user_details));
	        //$p_list[] = array(...);
	    }
	    return Response::json($p_list);

	}

	public function dummy(){
		//
	}


public function SectorWiseBusinessList()
{
	$user = Auth::user();
	$usr_selected_categories = BmCategory::where('user_id',$user->id)->orderBy('id', 'asc')->get();
	$page_no = Input::get('page_no') != null ? (int)Input::get('page_no'): 1 ;

	if ($usr_selected_categories)
	{
		if ($usr_selected_categories->count() < $page_no)
		{
			return Response::json(array("message"=>"not enough pages","code"=> -1));
		}
		$activity_codes = array();
		foreach ($usr_selected_categories as $cat) {
			$activity_code_set=ActivityCodeModel::where('code', 'LIKE', $cat->category_slug.'%')->groupBy('code')->orderBy('code', 'asc')->get();
			foreach ($activity_code_set as $acm) {
				$activity_codes[] = $acm->code;
			}
		}

		// $response = $this->SoapMemberDir(
		// 	array(
		// 	"activityCode"=>$activity_codes[$page_no-1],
		// 	"City"=>"",
		// 	"curPageNo"=>""
		// 	)
		// );
		$response = memberDirDataWriteThrough($activity_codes[$page_no-1]);
		// if(isset($response->MemberDetails))
		// {
		// 	//
		// }
	}


	else
	{
		// $response = $this->SoapMemberDir(
		// 		array(
		// 		"curPageNo"=>Input::get('page_no')
		// 		)
		// 	);
		$response = $this->memberDirDataWriteThrough("");
	}

	$json_response = Response::json(array("data"=>$response,"page_no"=>$page_no));
	$json_response->header('Content-Type', 'application/json');
	$json_response->header('charset', 'utf-8');
	return $json_response;

	
}


public function dcServerTest()
{
	$response = $this->memberDirDataWriteThrough("");
	$json_response = Response::json(array("data"=>$response));
	$json_response->header('Content-Type', 'application/json');
	$json_response->header('charset', 'utf-8');
	return $json_response;
}

private function SoapMemberDir($query)
{
	    $client = new SoapClient(
        "http://213.42.52.181:8301/soa-infra/services/default/MemberDirectory/bpel_memberdirectory_client_ep?WSDL"
        );
       $params = array (
	       "message" => array(
		       'MemberDetails'=>array(
			       "MemberNumber"=>  isset($query["MemberNumber"]) ? $query["MemberNumber"] :"",
			       "MemberNameEN"=>isset($query["MemberNameEN"]) ? $query["MemberNameEN"] :"",
			       "MemberEmail"=>isset($query["MemberEmail"]) ? $query["MemberEmail"] :"",
			       "MemberPhone"=>isset($query["MemberPhone"]) ? $query["MemberPhone"] :"", 
			       "BuildingStreet"=>isset($query["BuildingStreet"]) ? $query["BuildingStreet"] :"",
			       "BuildingArea"=>isset($query["BuildingArea"]) ? $query["BuildingArea"] :"",
			       "City"        =>isset($query["City"]) ? $query["City"] :"",
			       "activityCode"=>isset($query["activityCode"]) ? $query["activityCode"] :"",
			       "curPageNo"=>isset($query["curPageNo"]) ? $query["curPageNo"] :"",
		      	),
			),
		);
	$response = $client->__soapCall('process', $params);
	return $response;
}

private function memberDirDataWriteThrough($activity_code)
{
	// [Check if data exist in db else try to fetch from API].
	// Not a fool proof method but this is the best method to be adopted 
	// when API support is limited, and a db dump is not avaliable.

	// TODO parse all pages of an activitu code using  process queues.
	if ($activity_code == "")
	{
		$data_collection = DcMemberData::where("extra_data_activityCode",$activity_code)
		->get()->slice(0, 100);
	}
	else
	{
		$data_collection = DcMemberData::all()->slice(0, 100);
	}
	if($data_collection->first())
	{
		$memberlist = array();
		foreach ($data_collection as $arr)
		{
			$memberlist[]= array(
			"MemberNumber" => $arr->MemberNumber,
			"MemberNameEN" => $arr->MemberNameEN,
			"MemberEmail"  => $arr->MemberEmail,
			"MemberPhone"  => $arr->MemberPhone,
			"BuildingStreet" => $arr->BuildingStreet,
			"BuildingArea"   => $arr->BuildingArea,
			"City" => $arr->City,
			"MemberNameAR" => $arr->MemberNameAR,
			"MemberFax"    => $arr->MemberFax,
			"BuildingNameEng" => $arr->BuildingNameEng,
			"BuildingNameAra" => $arr->BuildingNameAra,
			"BuildingNo" => $arr->BuildingNo,
			"POBox"    => $arr->POBox,
			"Country"  => $arr->Country,
			"Province" => $arr->Province,
			);
		}
		$member_data = 	array("MemberDetails"=>
							$memberlist
						);
		return $member_data;

	}
	else
	{
		$response = $this->SoapMemberDir(
			array(
				"activityCode"=>$activity_code
				)
			);

		$bulk_array = array();
		if($response->MemberDetails)
		{
			// $count=0;
			foreach ($response->MemberDetails as $arr) 
			{
		    	$bulk_array[]= array(
				"MemberNumber" => $arr->MemberNumber,
				"MemberNameEN" => $arr->MemberNameEN,
				"MemberEmail"  => $arr->MemberEmail,
				"MemberPhone"  => $arr->MemberPhone,
				"BuildingStreet" => $arr->BuildingStreet,
				"BuildingArea"   => $arr->BuildingArea,
				"City" => $arr->City,
				"MemberNameAR" => $arr->MemberNameAR,
				"MemberFax"    => $arr->MemberFax,
				"BuildingNameEng" => $arr->BuildingNameEng,
				"BuildingNameAra" => $arr->BuildingNameAra,
				"BuildingNo" => $arr->BuildingNo,
				"POBox"    => $arr->POBox,
				"Country"  => $arr->Country,
				"Province" => $arr->Province,
				// Extra data
				"extra_data_activityCode"=> $activity_code
				);
				// $count++;
				// if($count % 105 == 0)
				// {
				// 	DcMemberData::insert($bulk_array);
				// 	$bulk_array = array();
				// }
			}
		}
		DcMemberData::insert($bulk_array);
		return $response;
	}

}


private function cleanString($strData)
{
	if($strData != "N/A")
		return $strData;
	else
		return "";
}

}
