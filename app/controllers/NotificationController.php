<?php

class NotificationController extends \BaseController {


	public function notificationList()
	{
		$host_path = Config::get('app.host_path');
		$user = Auth::user();
		$rules = array('page_no'     => 'integer',);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			$page = Input::get('page_no' );
			if($page > 0 )
				$offset =  $page * 10;
			else
				$offset=0;
			$notifications = Notification::where('user_id','=',$user->id)->idDescending()->get()->slice($offset, 10);
			
			$response_Array = array();

			foreach ($notifications as $noti)
		    {
		    	$notification = array('id'=>$noti->id,
		    		'read'=>$noti->read,
		    		'message'=>$noti->message,
		    		'item_type'=>$noti->item_type,
		    		'item_id'=>$noti->item_id,
		    		'created_at'=>$noti->created_at->toDateTimeString()
		    		);
		    	
		    	   	if($noti->item_type=="invite")
		    	   	{	
		    	   		$con = Connection::find($noti->item_id);
		    	   		if($con->receiver->profile->image != null) 
							$notification['image'] = $host_path.$con->receiver->profile->image;
		    	   	}
					else
						$notification['image'] = null;
				array_push($response_Array,$notification);
		        //$p_list[] = array(...);
		    }

			return Response::json($response_Array);
		}


	}

	public function markRead()
	{
		$user = Auth::user();
		$rules = array(
		    'notification_ids'  => 'required|array',
		    'read'  => 'required|integer',
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			$notis = Notification::find(Input::get('notification_ids' ));
			foreach ($notis as $noti) {
				if ( Input::get('read' ) == 1 )
					$noti->read = 1;
				else
					$noti->read = 0;
				$noti->save();
				}

			return Response::json(array('status'=>'success'));
		}
	}

}
