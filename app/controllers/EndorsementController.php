<?php

class EndorsementController extends \BaseController {

	public function show($id)
	{
		$user = Auth::user();
		$endorsement = Endorsement::find($id);
		return Response::json(array('endorsement' => $endorsement,'status'=>'success'));

	}


	public function endorsementList()
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
			$endorsements = Endorsement::where('to_user','=',$user->id)->idDescending()->get()->slice($offset, 10);
			$list = array();
			foreach ($endorsements as $endorsement)
			{
				$item = array('id'=>$endorsement->id,
				"from_user"=>$endorsement->from_user,
				"from_user_name"=>$endorsement->fromUser->name,
				"to_user"  =>$endorsement->to_user,
				"optional_msg"=>$endorsement->optional_msg);

				if($endorsement->fromUser->profile->image != null )
					$item['image'] = $host_path.$endorsement->fromUser->profile->image;
				else
					$item['image'] = null;

				$list[] = $item;
			}
			
			return Response::json(array('endorsement' => $list,'status'=>'success'));
		}
	}

	public function publicEndorsementList($id)
	{
		$rules = array('page_no'  => 'integer',);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			$user = User::find($id);
			$page = Input::get('page_no' );
			if($page > 0 )
				$offset =  $page * 10;
			else
				$offset=0;
			$list = Endorsement::where('to_user','=',$user->id)->idDescending()->get()->slice($offset, 10);
			return Response::json(array('endorsement' => $list,'status'=>'success'));
		}
	}

	public function add()
	{
		$rules = array(
			'user_id'  => 'required|integer|exists:users,id',
			//'optional_msg'  => 'alpha_num',
			);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			$user = Auth::user();
			$endorsement = Endorsement::firstOrNew(array('from_user' => $user->id,'to_user'=>Input::get('user_id')));
			if(!$endorsement->exists)
			{
				$endorsement->from_user = $user->id;
				$endorsement->to_user   = Input::get('user_id');
				$endorsement->optional_msg = (null !== Input::get('optional_msg')) ? Input::get('optional_msg') : null;
				$endorsement->save();
			}
			else
			{
				return Response::json(array('status'=>'failed','reason'=>'already exist!','endorsement'=>$endorsement));
			}

			return Response::json(array('status'=>'success','endorsement'=>$endorsement));
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
