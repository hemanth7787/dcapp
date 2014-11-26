<?php

class MeetingController extends \BaseController {

	
public function forward()
	{
		$user = Auth::user();
		
		$rules = array(
			'meeting_id'  => 'required|integer|exists:meetings,id',
			'timing'  => 'required|date_format:d-m-Y H:i',
			'timing_two'  => 'date_format:d-m-Y H:i',
			'timing_three'  => 'date_format:d-m-Y H:i',
			);
	$validator = Validator::make(Input::all(), $rules);
	if ($validator->fails()) 
	{
		return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
	}
	else
	{
		$meeting = Meeting::find(Input::get('meeting_id'));
		if($user->id != $meeting->msg_target_usr_id)
		{
			return Response::json(array('errors' => "You cannot accept , because its not forwarded to you",'status'=>'failed'));
		}
		
		if($meeting->confirmed == true)
		{
			return Response::json(array('errors' => "Meeting was finalized before",'status'=>'failed'));
		}

		$timing = date_parse_from_format("d-m-Y H:i", Input::get('timing'));
		$meeting->timing =  \Carbon\Carbon::create(
			$timing["year"],
			$timing["month"],
			$timing["day"],
			$timing["hour"],
			$timing["minute"], 0);

		 
		if (Input::get('timing_two'))
		{
			$timing_two = date_parse_from_format("d-m-Y H:i", Input::get('timing_two'));
		    $meeting->timing_two = \Carbon\Carbon::create(
									$timing_two["year"],
									$timing_two["month"],
									$timing_two["day"],
									$timing_two["hour"],
									$timing_two["minute"], 0);
		}
		if(Input::get('timing_three'))
		{
			$timing_three = date_parse_from_format("d-m-Y H:i", Input::get('timing_three'));
		    $meeting->timing_three =  \Carbon\Carbon::create(
									$timing_three["year"],
									$timing_three["month"],
									$timing_three["day"],
									$timing_three["hour"],
									$timing_three["minute"], 0);
		}
		 
		if($user->id == $meeting->from)
			$meeting->msg_target_usr_id = $meeting->to;
		else
			$meeting->msg_target_usr_id = $meeting->from;
		$meeting->save();

	}

	return Response::json(array('meeting' => $meeting,'status'=>'success'));

	}

	public function accept()
	{
		$user = Auth::user();
		
		$rules = array(
			'meeting_id'  => 'required|integer|exists:meetings,id',
			'accepted_timing_no'  => 'required|integer|between:1,3',
			);
	$validator = Validator::make(Input::all(), $rules);
	if ($validator->fails()) 
	{
		return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
	}
	else
	{
		$meeting = Meeting::find(Input::get('meeting_id'));
		if($user->id != $meeting->msg_target_usr_id)
		{
			return Response::json(array('errors' => "You cannot accept , because its not forwarded to you",'status'=>'failed'));
		}
		
		if($meeting->confirmed == true)
		{
			return Response::json(array('errors' => "Meeting was finalized before",'status'=>'failed'));
		}

		if (Input::get('accepted_timing_no')==1) 
		{
		    $meeting->confirmed_timing =  $meeting->timing;
		    //error_log("\n1\n");
		} 
		elseif (Input::get('accepted_timing_no')==2) 
		{
		    $meeting->confirmed_timing =  $meeting->timing_two;
		     //error_log("\n2\n");
		}
		else 
		{
			//error_log("\n3\n");
		    $meeting->confirmed_timing =  $meeting->timing_three;
		}
		 
		$meeting->confirmed = true;
		$meeting->save();

		// Add notification
		if($user->id==$meeting->from)
			$oth_user=$meeting->requestTo;
		else
			$oth_user=$meeting->requestFrom;

		$message = "Meeting with ".$user->name." confirmed";
		if($meeting->confirmed_timing!=null)
			$message = $message." at ".$meeting->confirmed_timing; //->toDateTimeString();
		Notification::create(array(
			'message'=> $message,
			'item_id'=>$meeting->id,
			'user_id' => $oth_user->id,
			'item_type'=>"meeting",
					));

		//add calender
		if($meeting->confirmed_timing!=null)
		{
			Calender::create(array(
			'date'=> $meeting->confirmed_timing,
			'item_id'=>$meeting->id,
			'user_id' => $oth_user->id,
			'item_id_type'=>"meeting",
					));

			Calender::create(array(
			'date'=> $meeting->confirmed_timing,
			'item_id'=>$meeting->id,
			'user_id' => $user->id,
			'item_id_type'=>"meeting",
					));
		}


	}

	return Response::json(array('meeting' => $meeting,'status'=>'success'));

	}


	public function requestList()
	{
		$rules = array('page_no'  => 'integer',);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			$host_path = Config::get('app.host_path');
			$user = Auth::user();
			$page = Input::get('page_no');
			if($page > 0 )
				$offset =  $page * 10;
			else
				$offset=0;
			$meetings = Meeting::where('msg_target_usr_id','=',$user->id)
			->where('confirmed','=',false)
			->idDescending()->get()->slice($offset, 10);
			$list = array();
			foreach ($meetings as $meeting)
			{
				$item = array();
				$item['id'] = $meeting->id;
				$item["optional_msg"] = $meeting->optional_msg;
				$item['timing'] = $meeting->timing;
				$item['timing_two'] = $meeting->timing_two;
				$item['timing_three'] = $meeting->timing_three;

				if($user->id == $meeting->from)
					$oth_user = $meeting->requestTo;
				else
					$oth_user = $meeting->requestFrom;

				$item["from_user_id"] = $oth_user->id;
				$item["from_user_name"] = $oth_user->name;

				if($oth_user->profile)
				{
					if($oth_user->profile->image != null )
						$item['image'] = $host_path.$oth_user->profile->image;
					else
						$item['image'] = null;
				}
				

				$list[] = $item;
			}
			
			return Response::json(array('meetings' => $list,'status'=>'success'));
		}
	}


	public function meetingList()
	{
		$rules = array('page_no'  => 'integer',);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			$host_path = Config::get('app.host_path');
			$user = Auth::user();
			$page = Input::get('page_no');
			if($page > 0 )
				$offset =  $page * 10;
			else
				$offset=0;
			$meetings = Meeting::where('to','=',$user->id)
			->orWhere('from','=',$user->id)
			->where('confirmed','=',true)->get()->slice($offset, 10);
			$list = array();
			foreach ($meetings as $meeting)
			{
				$item = array();
				$item['id'] = $meeting->id;
				$item["optional_msg"] = $meeting->optional_msg;
				$item['confirmed_timing'] = $meeting->confirmed_timing;

				if($user->id == $meeting->from)
					$oth_user = $meeting->requestTo;
				else
					$oth_user = $meeting->requestFrom;

				$item["from_user_id"] = $oth_user->id;
				$item["from_user_name"] = $oth_user->name;

				if($oth_user->profile)
				{
					if($oth_user->profile->image != null )
						$item['image'] = $host_path.$oth_user->profile->image;
					else
						$item['image'] = null;
				}
				

				$list[] = $item;
			}
			
			return Response::json(array('meetings' => $list,'status'=>'success'));
		}
	}

	public function add()
	{
		$rules = array(
			'to_user_id'  => 'required|integer|exists:users,id',
			'timing'  => 'date_format:d-m-Y H:i',
			'timing_two'  => 'date_format:d-m-Y H:i',
			'timing_three'  => 'date_format:d-m-Y H:i',
			'optional_msg'  => 'max:200',
			);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			$user = Auth::user();
			$meeting = new Meeting();
			$meeting->to = Input::get('to_user_id');

			if(Input::get('timing'))
			{
				$dt = date_parse_from_format("d-m-Y H:i", Input::get('timing'));
				$meeting->timing = \Carbon\Carbon::create($dt["year"], $dt["month"], $dt["day"], $dt["hour"], $dt["minute"], 0);

			}

			$zerohrs = new DateTime('00:00');

			if(Input::get('timing_two'))
			{
				$dt = date_parse_from_format("d-m-Y H:i", Input::get('timing_two'));
				// Iphone empty time send fix
				$twodt = new DateTime(Input::get('timing_two'));
				if($twodt->format('H:i') != $zerohrs->format('H:i'))
				{
					$meeting->timing_two = \Carbon\Carbon::create($dt["year"], $dt["month"], $dt["day"], $dt["hour"], $dt["minute"], 0);
				}
			}

			if(Input::get('timing_three'))
			{
				$dt = date_parse_from_format("d-m-Y H:i", Input::get('timing_three'));
				// Iphone empty time send fix
				$threedt = new DateTime(Input::get('timing_two'));
				if($threedt->format('H:i') != $zerohrs->format('H:i'))
				{
					$meeting->timing_three = \Carbon\Carbon::create($dt["year"], $dt["month"], $dt["day"], $dt["hour"], $dt["minute"], 0);
				}
				

			}
			
			$meeting->optional_msg = Input::get('optional_msg');
			$meeting->from = $user->id;
			$meeting->msg_target_usr_id = Input::get('to_user_id');
			$meeting->save();

			// Add notification
			$message = $user->name." has send you a meeting request.";
				Notification::create(array(
				'message'=> $message,
				'item_id'=>$meeting->id,
				'user_id' => $meeting->msg_target_usr_id,
				'item_type'=>"meeting",
						));


			return Response::json(array('status'=>'success','meeting'=>$meeting));
		}
	}

	// public function delete()
	// {
	// 	$user = Auth::user();
	// 	$rules = array(
	// 	    'endorsement_ids'  => 'required|array',
	// 	);
	// 	$validator = Validator::make(Input::all(), $rules);
	// 	if ($validator->fails()) 
	// 	{
	// 		return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
	// 	}
	// 	else
	// 	{

	// 		$endorsements = Endorsement::where('to_user','=',$user->id)->find(Input::get('endorsement_ids' ));
	// 		$count=0;
	// 		foreach ($endorsements as $endorsement)
	// 		{
	// 			$endorsement->delete();
	// 			$count++;
	// 		}
	// 		return Response::json(array('status'=>'success','deleted_items'=>$count));
	// 	}
	// }


}
