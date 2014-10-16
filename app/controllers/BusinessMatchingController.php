<?php

class BusinessMatchingController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getCategories()
	{
		$user = Auth::user();
		$categories = $user->categories;
		return Response::json($categories);
	}

	public function setCategories()
	{
		// $comments = array(
  		// new Comment(array('message' => 'A new comment.')),
  		// new Comment(array('message' => 'Another comment.')),
		// 	new Comment(array('message' => 'The latest comment.'))
		// );

		// $post = Post::find(1);

		// $post->comments()->saveMany($comments);

		// $comment = new Comment(array('message' => 'A new comment.'));
		// $post = Post::find(1);
		// $comment = $post->comments()->save($comment);

		$rules = array(
		    //'user_id'       => 'required|integer|exists:users,id',
		    'parent_category'  => 'required|alpha_dash|max:50',
		    'child_category'   => 'required|alpha_dash|max:50',

		);
		$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else{

			$user = Auth::user();
			$profile = BmCategory::firstOrCreate(array('user_id' => $user->id,
				'parent_category' => Input::get('parent_category'),
				'child_category'  => Input::get('child_category')));
			return Response::json(array('status'=>'success'));
		}
	}

		public function getBm()
	{
		$user = Auth::user();
		$bm = BusinessMatching::firstOrCreate(array('user_id' => $user->id));
		return Response::json($bm);
	}

	public function setBm()
	{

		$rules = array(
		    'provides'        => 'required|alpha|max:10',
		    'employee_count'  => 'required|integer',
		    'annual_turnover' => 'required|integer'
		);
		$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else{

			$user = Auth::user();
			$bm = BusinessMatching::firstOrCreate(array('user_id' => $user->id));
			$bm->provides = Input::get('provides');
			$bm->employee_count  = Input::get('employee_count');
			$bm->annual_turnover = Input::get('annual_turnover');
			$bm->save();

			return Response::json(array('status'=>'success'));
		}
	// 
	}




}
