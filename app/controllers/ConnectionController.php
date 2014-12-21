<?php

class ConnectionController extends \BaseController {

	public function public_connections($id)
	{
		$user = User::find($id);
		$my_connections = Connection::where('to','=',$user->id)
		->orWhere('from','=',$user->id)
		->where('accept','=',true)->get();
		//var_dump($my_connections);
		$host_path = Config::get('app.host_path');

		
		$p_list = array();
		foreach ($my_connections as $con)
	    {
	    	$item = array('connection_id'=>$con->id,
	    				'created_at'=>$con->created_at->toDateTimeString(),
	    				'updated_at'=>$con->updated_at->toDateTimeString(),
	    				'user_name'=>0,
	    				'user_id'=>0
	    				);
	        if($con->initiator->id == $user->id)
	        {
	        	$item['user_name'] =  $con->receiver->name;
   				$item['user_id']   =  $con->receiver->id;
   				$item['company_name']   =  $con->receiver->profile->company_name;
   				$item['designation']   =  $con->receiver->profile->designation;
   				if($con->receiver->profile->image != null )
					$item['image'] = $host_path.$con->receiver->profile->image;
				else
					$item['image'] = null;
	        }
	        else
	        {
   				$item['user_name'] = $con->initiator->name;
   				$item['user_id']   = $con->initiator->id;
   				$item['company_name']   =  $con->initiator->profile->company_name;
   				$item['designation']   =  $con->initiator->profile->designation;
   				if($con->initiator->profile->image != null )
					$item['image'] = $host_path.$con->initiator->profile->image;
				else
					$item['image'] = null;
			}
			array_push($p_list, $item);
	    }
	    return Response::json($p_list);
	}
	public function my_connections()
	{
		$user = Auth::user();

		$my_connections = Connection::where('to','=',$user->id)
		->orWhere('from','=',$user->id)
		->where('accept','=',true)->get();
		//var_dump($my_connections);
		$host_path = Config::get('app.host_path');

		
		$p_list = array();
		foreach ($my_connections as $con)
	    {
	    	$item = array('connection_id'=>$con->id,
	    				'created_at'=>$con->created_at->toDateTimeString(),
	    				'updated_at'=>$con->updated_at->toDateTimeString(),
	    				'user_name'=>0,
	    				'user_id'=>0
	    				);
	        if($con->initiator->id == $user->id)
	        {
	        	$item['user_name'] =  $con->receiver->name;
   				$item['user_id']   =  $con->receiver->id;
   				if($con->receiver->profile!=null)
   				{
   				$item['company_name']   =  $con->receiver->profile->company_name;
   				$item['designation']   =  $con->receiver->profile->designation;
   				if($con->receiver->profile->image != null )
					$item['image'] = $host_path.$con->receiver->profile->image;
				else
					$item['image'] = null;
   				}
   				else
   				{
   					$item['company_name']   = null;
   					$item['designation']   = null;
   					$item['image'] = null;

   				}
	        }
	        else
	        {
   				$item['user_name'] = $con->initiator->name;
   				$item['user_id']   = $con->initiator->id;
   				if($con->initiator->profile != null )
   				{
	   				$item['company_name']   =  $con->initiator->profile->company_name;
	   				$item['designation']   =  $con->initiator->profile->designation;
	   				if($con->initiator->profile->image != null )
						$item['image'] = $host_path.$con->initiator->profile->image;
					else
						$item['image'] = null;
   				}
   				else
   				{
   					$item['company_name']   = null;
   					$item['designation']   = null;
   					$item['image'] = null;

   				}
			}
			array_push($p_list, $item);
	    }
	    return Response::json($p_list);
	}

	public function open_invites()
	{
		$host_path = Config::get('app.host_path');
		$user = Auth::user();

		$my_connections = Connection::where('to','=',$user->id)->where('accept','=',false)->get();

		
		$p_list = array();
		foreach ($my_connections as $con)
	    {
	    	$invitation = array('invitaion_id'=>$con->id,
	    		'from_user_id'=>$con->initiator->id,
	    		'from_user_name'=>$con->initiator->name,
	    		'created_at'=>$con->created_at->toDateTimeString());
	    	
	    	   	if($con->initiator->profile->image != null )
					$invitation['image'] = $host_path.$con->initiator->profile->image;
				else
					$invitation['image'] = null;
			array_push($p_list,$invitation);
	        //$p_list[] = array(...);
	    }
	    return Response::json($p_list);
	}

	public function invite()
	{
		$rules = array('recipient_id'  => 'required|integer|exists:users,id',);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			$user = Auth::user();
			$reverse_connection = Connection::where('from','=',Input::get('recipient_id'))
			->where('to','=', $user->id)->get();
			if (!$reverse_connection->isEmpty())
			{
				return Response::json(array('errors' => "reverse connection/invite already exists",
					'status'=>'failed',"error_code"=>"2"));
			}
			$con = Connection::firstOrNew(array('from' => $user->id,'to'=>Input::get('recipient_id')));
			if($con->exists){
				return Response::json(array('errors' => "connection/invite already exists",
					'status'=>'failed',"error_code"=>"1"));
			}
			else
			{
				$recipient = User::find(Input::get('recipient_id'));
				$con->save();
				$status_array = array('status'=>'success');
				$message = $user->name.' has send you a connection request';

				$noti = new Notification();
				$noti->message = $message;
				$noti->item_id = $con->id;
				$noti->from_user = $user->id;
				$noti->user_id = Input::get('recipient_id');
				$noti->item_type = "invite";
				$noti->save();


				if($recipient->deviceToken==null)
				{
					$status_array['message'] = 'Message not delivered';
					$status_array['reason'] = 'Recipient device token missing';
				}
				else
				{
					$deviceToken = $user->deviceToken;
					$private_key = Config::get('app.apple_private_key');
					$passphrase = Config::get('app.apple_private_key_passphrase');
					// $message
					// Create the payload body
					$body['aps'] = array(
						'alert' => $message,
						'sound' => 'default',
						'badge' => 1 // put count here
						);

					$ctx = stream_context_create();
					stream_context_set_option($ctx, 'ssl', 'local_cert', $private_key);
					stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
					// Open a connection to the APNS server
					$fp = stream_socket_client(
						'ssl://gateway.sandbox.push.apple.com:2195', $err,
						$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
					if (!$fp)
						exit("Failed to connect: $err $errstr" . PHP_EOL);
					// echo 'Connected to APNS' . PHP_EOL;
					// Encode the payload as JSON
					$payload = json_encode($body);
					// Build the binary notification
					$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
					// Send it to the server
					$result = fwrite($fp, $msg, strlen($msg));
					if (!$result)
						$status_array['message'] = 'Message not delivered';
					else
						$status_array['message'] = 'Message successfully delivered';
					// Close the connection to the server
					fclose($fp);
				}

				return Response::json($status_array);
			}
		}
	}

	public function accept()
	{
		$rules = array('invitation_id'  => 'required|integer',);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
 			$con = Connection::find(Input::get('invitation_id'));
 			$user = Auth::user();
 			if($con->to != $user->id)
 			{
 				// Security measure: To prevent users from accepting invitaions addressed to others
 				return Response::json(array('errors' => "insufficient permissions to accept this invitation",
					'status'=>'failed',"error_code"=>"1"));

 			}
 			$con->accept = true;
 			$con->save();

 			$message = $user->name." Has acceped your connection request";

			$noti = new Notification();
			$noti->message = $message;
			$noti->item_id = $con->id;
			$noti->user_id = $con->from;
			$noti->from_user = $user->id;
			$noti->item_type = "noti";
			$noti->save();

 			return Response::json(array('status'=>'success'));
		}
	}

	public function delete()
	{
		$rules = array('connection_id'  => 'required|integer',);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
 			$con = Connection::find(Input::get('connection_id'));
 			$user = Auth::user();
 			if($con->from == $user->id || $con->to == $user->id)
 			{
 				$con->delete();
 				return Response::json(array('status'=>'success'));
 			}
 			else
 			{
 				// Security measure: To prevent users from accepting invitaions addressed to others
 				return Response::json(array('errors' => "insufficient permissions to delete this connection",
					'status'=>'failed',"error_code"=>"1"));

 			}
		}
	}

	public function alpha()
	{
	$client = new SoapClient(
	"http://dcvmsoamwsit.dubaichamber.com:8301/soa-infra/services/default/MemberDirectory/bpel_memberdirectory_client_ep?WSDL");
	    			$params = array (
    			"userName" => $username,
    			"password" => $password,
    			);
				$response = $client->__soapCall('QBECommDir', $params);
				return print_r($response);
	}
		public function beta()
	{
	$client = new SoapClient(
	"http://213.42.52.181:8301/soa-infra/services/default/MemberDirectory/bpel_memberdirectory_client_ep?WSDL");
	    			$params = array (
    			"userName" => $username,
    			"password" => $password,
    			);
				$response = $client->__soapCall('QBECommDir', $params);
				return print_r($response);
	}

}
