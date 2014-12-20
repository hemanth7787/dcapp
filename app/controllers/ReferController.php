<?php

class ReferController extends \BaseController {

	public function index()
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

			$refers = Refer::where('to_uid','=',$user->id)
			->get()->slice($offset, 10);

			$list = array();
			foreach ($refers as $refer)
			{
				$item = array();
				$item['id'] = $refer->id;
				$item["optional_msg"] = $refer->optional_msg;

				$item["from_user_id"]   = $refer->from_uid;
				$item["from_user_name"] = $refer->referFrom->name;
				$item["item_id"]   = $refer->item_id;
				$item["item_type"] = $refer->item_type;

				if($refer->referFrom->profile)
				{
					if($refer->referFrom->profile->image != null )
						$item['image'] = $host_path.$refer->referFrom->profile->image;
					else
						$item['image'] = null;
				}
				

				$list[] = $item;
			}
			
			return Response::json(array('refers' => $list,'status'=>'success'));
		}

	}


	public function add()
	{
		
		//$my_connections = Connection::where('to','=',$user->id)->where('accept','=',false)->get();

		$rules = array(
			'to_user_id'  => 'required|integer|exists:users,id',
			'item_id'     => 'required|integer',
			'item_type'   => 'required|max:20',
			'optional_msg'  => 'max:200',
			);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			$host_path = Config::get('app.host_path');
			$user = Auth::user();

			$refer = new Refer();
			$refer->from_uid = $user->id;
			$refer->to_uid   = Input::get('to_user_id');
			$refer->item_id  = Input::get('item_id');
			$refer->item_type    = Input::get('item_type');
			$refer->optional_msg = Input::get('optional_msg');
			$refer->save();

			//Add notification
			$message = $user->name." has shared an item with you.";
				Notification::create(array(
				'message'=> $message,
				'item_id'=> $refer->id,
				'user_id'  => $refer->to_uid,
				'from_user'=> $user->id,
				'item_type'=>"refer",
						));


			return Response::json(array('status'=>'success','refer_object'=>$refer));

		}
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


}
