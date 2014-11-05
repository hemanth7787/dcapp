<?php

class BoomarkController extends \BaseController {

	public function add()
	{
		$rules = array(
			'title'  => 'required|alpha_num',
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
			$bookmark = new Bookmark();
			$bookmark->user_id = $user->id;
			$bookmark->title   = Input::get('title');
			$bookmark->item_id = Input::get('item_id');
			$bookmark->item_id_type   = Input::get('item_id_type');
			$bookmark->item_parameter = Input::get('item_parameter');
			$bookmark->item_param_type = Input::get('item_parm_type');
			$bookmark->save();

			return Response::json(array('status'=>'success','bookmark'=>$bookmark));
		}
	}

	public function bookmarkList()
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
			$list = Bookmark::where('user_id','=',$user->id)->idDescending()->get()->slice($offset, 10);
			return Response::json(array('bookmarks' => $list,'status'=>'success'));
		}
	}

	public function show($id)
	{
		$user = Auth::user();
		$bookmark = Bookmark::find($id);

		if ($bookmark->user_id != $user->id)
		{
			return Response::json(array('errors' => "insufficient permission",'status'=>'failed'));
		}
		else
		{
			return Response::json(array('bookmark' => $bookmark,'status'=>'success'));
		}
	}

	public function delete()
	{
		$user = Auth::user();
		$rules = array(
		    'bookmark_ids'  => 'required|array',
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{

			$bookmarks = Bookmark::where('user_id','=',$user->id)->find(Input::get('bookmark_ids' ));
			$count=0;
			foreach ($bookmarks as $bookmark)
			{
				$bookmark->delete();
				$count++;
			}
			return Response::json(array('status'=>'success','deleted_items'=>$count));
		}

	}

}
