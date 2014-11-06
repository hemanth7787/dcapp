<?php

class CalenderController extends \BaseController {


	public function show($id)
	{
		$user = Auth::user();
		$calender = Calender::find($id);

		if ($calender->user_id != $user->id)
		{
			return Response::json(array('errors' => "insufficient permission",'status'=>'failed'));
		}
		else
		{
			return Response::json(array('calender' => $calender,'status'=>'success'));
		}
	}

	public function calenderList()
	{
		$rules = array('page_no'  => 'integer',);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			$user = Auth::user();
			$page = Input::get('page_no' );
			if($page > 0 )
				$offset =  $page * 10;
			else
				$offset=0;
			$list = Calender::where('user_id','=',$user->id)->idDescending()->get()->slice($offset, 10);
			return Response::json(array('calenders' => $list,'status'=>'success'));
		}
	}



	public function add()
	{
		$rules = array(
			//$date = "6.1.2009 13:00+01:00";
			//print_r(date_parse_from_format("j.n.Y H:iP", $date));
			'date'  => 'required|date_format:d-m-Y H:i',
			'item_id'  => 'required_with:item_id_type|integer',
			'item_id_type'  => 'required_with:item_id|alpha_num',
			'item_parameter'  => 'required_with:item_parameter_type',
			'item_parm_type'  => 'required_with:item_parameter',
			);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			$user = Auth::user();
			$cal = new Calender();
			$cal->user_id = $user->id;

			$dt = date_parse_from_format("d-m-Y H:i", Input::get('date'));
			$cal->date   = \Carbon\Carbon::create($dt["year"], $dt["month"], $dt["day"], $dt["hour"], $dt["minute"], 0);
			$cal->item_id = Input::get('item_id');
			$cal->item_id_type   = Input::get('item_id_type');
			$cal->item_parameter = Input::get('item_parameter');
			$cal->item_param_type = Input::get('item_parm_type');
			$cal->save();

			return Response::json(array('status'=>'success','calender'=>$cal));
		}
	}



	public function update($id)
	{
		//
	}



	public function delete()
	{
		$user = Auth::user();
		$rules = array(
		    'calender_ids'  => 'required|array',
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{

			$calenders = Calender::where('user_id','=',$user->id)->find(Input::get('calender_ids' ));
			$count=0;
			foreach ($calenders as $calender)
			{
				$calender->delete();
				$count++;
			}
			return Response::json(array('status'=>'success','deleted_items'=>$count));
		}
	}


}
