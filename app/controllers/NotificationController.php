<?php

class NotificationController extends \BaseController {


	public function notificationList()
	{
		$user = Auth::user();
		$rules = array('page_no'     => 'integer',);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			//
		}
		$page = Input::get('page_no' );
		if($page > 0 )
			$offset =  $page * 10;
		else
			$offset=0;
		
		$notifications = Notification::where('user_id','=',$user->id)->idDescending()->get()->slice($offset, 10);
		return Response::json($notifications);

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
