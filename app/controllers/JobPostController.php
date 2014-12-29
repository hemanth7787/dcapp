<?php

class JobPostController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
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
			// $host_path = Config::get('app.host_path');
			$user = Auth::user();
			$page = Input::get('page_no');
			if($page > 0 )
				$offset =  $page * 10;
			else
				$offset=0;
			$posts = JobPost::where('active',true)->with('user.profile')->get()->slice($offset, 10);
			return Response::json($posts);
		}
	}

	public function myJobPostings()
	{
		$rules = array('page_no'  => 'integer',);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			// $host_path = Config::get('app.host_path');
			$user = Auth::user();
			$page = Input::get('page_no');
			if($page > 0 )
				$offset =  $page * 10;
			else
				$offset=0;
			$posts = JobPost::where('user_id',$user->id)
				->where('active',true)->get()->slice($offset, 10);
			return Response::json($posts);
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{	
		$rules = array(
			'title'        => 'required|max:100',
			'description'  => 'required|max:500',
			'due_date'     => 'date_format:d-m-Y H:i',
			);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			// $host_path = Config::get('app.host_path');
			$user = Auth::user();
			$post = new JobPost();
			$post->user_id = $user->id;
			$post->title   = Input::get('title');
			$post->description   = Input::get('description');
			if(Input::get('due_date'))
			{
				$dt = date_parse_from_format("d-m-Y H:i", Input::get('due_date'));
				$post->due_date = \Carbon\Carbon::create($dt["year"], $dt["month"], $dt["day"], $dt["hour"], $dt["minute"], 0);

			}
			$post->active  = true;
			$post->save();
			return Response::json(array('status'=>'success','job_post'=>$post));

		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		$rules = array('job_post_id'  => 'required|integer|exists:job_posts,id',);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			$post = JobPost::find(Input::get('job_post_id'));
			return Response::json(array('status'=>'success','job_post'=>$post));
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		$rules = array(
			'job_post_id'  => 'required|integer|exists:job_posts,id',
			'title'        => 'required|max:100',
			'description'  => 'required|max:500',
			'due_date'     => 'date_format:d-m-Y H:i',
			);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			$user = Auth::user();
			$post = JobPost::find(Input::get('job_post_id'));
			if($post->user_id != $user->id)
				return Response::json(array('status'=>'failed','reson'=>'Insufficient permission'));
			
			$post->title   = Input::get('title');
			$post->description   = Input::get('description');
			if(Input::get('due_date'))
			{
				$dt = date_parse_from_format("d-m-Y H:i", Input::get('due_date'));
				$post->due_date = \Carbon\Carbon::create($dt["year"], $dt["month"], $dt["day"], $dt["hour"], $dt["minute"], 0);

			}
			//$refer->active  = true;
			$post->save();
			return Response::json(array('status'=>'success','job_post'=>$post));

		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		$rules = array('job_post_id'  => 'required|integer|exists:job_posts,id',);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{	
			$user = Auth::user();

			$post = JobPost::find(Input::get('job_post_id'));

			if($post->user_id != $user->id)
				return Response::json(array('status'=>'failed','reson'=>'Insufficient permission'));
			
			$post->active   = false;
			$post->save();
			return Response::json(array('status'=>'success','job_post'=>$post));
		}
	}


}
