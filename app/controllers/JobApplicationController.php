<?php

class JobApplicationController extends \BaseController {

	// All job applications received for my job post
	public function inboundList()
	{
		$rules = array(
			'page_no'    => 'integer',
			'job_post_id'=> 'required|integer|exists:job_posts,id'
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
			$page = Input::get('page_no');
			if($page > 0 )
				$offset =  $page * 10;
			else
				$offset=0;

			$post = JobPost::find(Input::get('job_post_id'));
			if($post->user_id != $user->id)
				return Response::json(array('status'=>'failed','reson'=>'Insufficient permission'));
			
			$applications = JobApplication::with('user')->where('job_post_id',$post->id)->get()->slice($offset, 10);
			return Response::json($applications);
		}
	}

	// All job applications by me
	public function outboundList()
	{
		$rules = array(
			'page_no'    => 'integer',
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
			$page = Input::get('page_no');
			if($page > 0 )
				$offset =  $page * 10;
			else
				$offset=0;
			
			$applications = JobApplication::with('JobPost')->where('user_id',$user->id)
				->get()->slice($offset, 10);
			return Response::json($applications);
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{	
		$rules = array('job_post_id'=> 'required|integer|exists:job_posts,id');
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			$post = JobPost::find(Input::get('job_post_id'));
			$user = Auth::user();
			if($post->active == false)
				return Response::json(array('status'=>'failed','reason'=>'Cannot apply for a non-existant Job post'));

			$appl = JobApplication::firstOrCreate(array(
				'user_id' => $user->id,
				'job_post_id'=>Input::get('job_post_id')
				));
			return Response::json(array('status'=>'success','job_application'=>$appl));
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
		$rules = array('job_application_id'=> 'required|integer|exists:job_applications,id');
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) 
		{
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{
			$appl = JobApplication::find(Input::get('job_application_id'));
			$user = Auth::user();

			if($appl->user_id != $user->id)
				return Response::json(array('status'=>'failed','reson'=>'Insufficient permission'));
			$appl->delete();
			return Response::json(array('status'=>'success','job_application'=>$appl));
		}
	}


}
