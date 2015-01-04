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
		$client = new SoapClient('https://dcsoamw.dubaichamber.com:8012/DCCICommercialDirectory/ProxyServices/DCCICommercialDirectoryProxy');
		$xml = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:dcq="http://siebel.com/DCQueryMobCommDir" xmlns:dc="http://www.siebel.com/xml/DC%20Query%20Member%20Info">
<soapenv:Header>
<wsse:Security xmlns:wsse="http://schemas.xmlsoap.org/ws/2002/07/secext">
<wsse:UsernameToken xmlns:wsu="http://schemas.xmlsoap.org/ws/2002/07/utility">
<wsse:Username>MOBILEUSER</wsse:Username>
<wsse:Password Type="wsse:PasswordText">MOBILEUSER</wsse:Password>
</wsse:UsernameToken>
</wsse:Security>
</soapenv:Header>
   <soapenv:Body>
      <dcq:QBECommDir>
         <SiebelMessage>
            <dc:ListOfDcQueryMemberInfo>
               <!--Zero or more repetitions:-->
               <dc:Account>
                  <!--Optional:-->
                  <dc:CSN/>
                  <dc:DCNameArabic/>
                  <dc:DCNameEnglish>* Futtaim *</dc:DCNameEnglish>
                  <!--Optional:-->
                  <dc:MainEmailAddress/>
                  <!--Optional:-->
                  <dc:MainFaxNumber/>
                  <!--Optional:-->
                  <dc:MainPhoneNumber/>
                  <!--Optional:-->
                  <dc:Name/>
                  <!--Optional:-->
                  <dc:ListOfAccount_BusinessAddress>
                     <!--Zero or more repetitions:-->
                     <dc:Account_BusinessAddress>
                        <!--Optional:-->
                        <dc:ApartmentNumber/>
                        <dc:City/>
                        <!--Optional:-->
                        <dc:Country/>
                        <!--Optional:-->
                        <dc:DCAreaPOBox/>
                        <!--Optional:-->
                        <dc:DCBuildingNameArabic/>
                        <!--Optional:-->
                        <dc:DCBuildingNammeEnglish/>
                        <!--Optional:-->
                        <dc:Province/>
                        <dc:Street/>
                        <dc:StreetAddress/>
                        <dc:AddressName/>
                     </dc:Account_BusinessAddress>
                  </dc:ListOfAccount_BusinessAddress>
                  <!--Optional:-->
                  <dc:ListOfAccount_DCAccountActivity>
                     <!--Zero or more repetitions:-->
                     <dc:Account_DCAccountActivity>
                        <!--Optional:-->
                        <dc:DCActivityCode/>
                        <!--Optional:-->
                        <dc:DCActivityDesArabic/>
                        <!--Optional:-->
                        <dc:DCActivityDescriptionEng/>
                     </dc:Account_DCAccountActivity>
                  </dc:ListOfAccount_DCAccountActivity>
               </dc:Account>
            </dc:ListOfDcQueryMemberInfo>
         </SiebelMessage>
      </dcq:QBECommDir>
   </soapenv:Body>
</soapenv:Envelope>';
    			$params = array (
    			"userName" => 'MOBILEUSER',
    			"password" => 'MOBILEUSER',
    			);
$response = $client->__soapCall('authWithProfile', $params);
				$parser = simplexml_load_string($response);
				return var_dump($parser);

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

		$response = $this->SoapMemberDir(
			array(
			"activityCode"=>$activity_codes[$page_no-1],
			"City"=>"",
			"curPageNo"=>""
			)
		);
		// if(isset($response->MemberDetails))
		// {
		// 	//
		// }
	}


	else
	{
		$response = $this->SoapMemberDir(
				array(
				"curPageNo"=>Input::get('page_no')
				)
			);
	}

	$json_response = Response::json(array("data"=>$response,"page_no"=>$page_no));
	$json_response->header('Content-Type', 'application/json');
	$json_response->header('charset', 'utf-8');
	return $json_response;

	
}


public function dcServerTest()
{
	$response = $this->SoapMemberDir(array());
	$json_response = Response::json(array($response));
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

}
