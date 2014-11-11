<?php

class MeetingController extends \BaseController {

	// public function show($id)
	// {
	// 	$user = Auth::user();
	// 	$endorsement = Endorsement::find($id);
	// 	return Response::json(array('endorsement' => $endorsement,'status'=>'success'));

	// }


	// public function meetingList()
	// {
	// 	$rules = array('page_no'  => 'integer',);
	// 	$validator = Validator::make(Input::all(), $rules);
	// 	if ($validator->fails())
	// 	{
	// 		return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
	// 	}
	// 	else
	// 	{
	// 		$host_path = Config::get('app.host_path');
	// 		$user = Auth::user();
	// 		$page = Input::get('page_no');
	// 		if($page > 0 )
	// 			$offset =  $page * 10;
	// 		else
	// 			$offset=0;
	// 		$endorsements = Endorsement::where('to_user','=',$user->id)->idDescending()->get()->slice($offset, 10);
	// 		$list = array();
	// 		foreach ($endorsements as $endorsement)
	// 		{
	// 			$item = array('id'=>$endorsement->id,
	// 			"from_user"=>$endorsement->from_user,
	// 			"from_user_name"=>$endorsement->fromUser->name,
	// 			"to_user"  =>$endorsement->to_user,
	// 			"optional_msg"=>$endorsement->optional_msg);

	// 			if($endorsement->fromUser->profile->image != null )
	// 				$item['image'] = $host_path.$endorsement->fromUser->profile->image;
	// 			else
	// 				$item['image'] = null;

	// 			$list[] = $item;
	// 		}
			
	// 		return Response::json(array('endorsement' => $list,'status'=>'success'));
	// 	}
	// }

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

			if(Input::get('timing_two'))
			{
				$dt = date_parse_from_format("d-m-Y H:i", Input::get('timing_two'));
				$meeting->timing_two = \Carbon\Carbon::create($dt["year"], $dt["month"], $dt["day"], $dt["hour"], $dt["minute"], 0);

			}

			if(Input::get('timing_three'))
			{
				$dt = date_parse_from_format("d-m-Y H:i", Input::get('timing_three'));
				$meeting->timing_three = \Carbon\Carbon::create($dt["year"], $dt["month"], $dt["day"], $dt["hour"], $dt["minute"], 0);

			}
			
			$meeting->optional_msg = Input::get('optional_msg');
			$meeting->from = $user->id;
			$meeting->msg_target_usr_id = Input::get('to_user_id');
			$meeting->save();


			return Response::json(array('status'=>'success','meeting'=>$meeting));
		}
	}

	public function delete()
	{
		$user = Auth::user();
		$rules = array(
		    'endorsement_ids'  => 'required|array',
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{

			$endorsements = Endorsement::where('to_user','=',$user->id)->find(Input::get('endorsement_ids' ));
			$count=0;
			foreach ($endorsements as $endorsement)
			{
				$endorsement->delete();
				$count++;
			}
			return Response::json(array('status'=>'success','deleted_items'=>$count));
		}
	}


}
