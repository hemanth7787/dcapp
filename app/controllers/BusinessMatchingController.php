<?php

class BusinessMatchingController extends \BaseController {

	public function getCategoryList()
	{
		//$user = Auth::user();
		$categories = DynamicCategory::where('parent_slug','root')->get();
		$items=array();
		foreach ($categories as $category) {
			$items[] = array(
				'name'=>$category->name,
				'slug' =>$category->slug,
				'parent_id'=>$category->parent_id,
				'parent_slug' => $category->parent_slug
				);
		}
		return Response::json(array('root'=>$items));
	}

	public function getCategories()
	{
		$user = Auth::user();
		$categories = $user->categories;
		return Response::json($categories);
	}

	public function deleteCategories()
	{
		$rules = array(
		    'parent_category'  => 'required|alpha_dash|max:50',
		    'child_category'   => 'required|alpha_dash|max:50',

		);
		$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else{

		$user = Auth::user();
		// $categories = BmCategory::find(array('user_id' => $user->id,
		// 		'parent_category' => Input::get('parent_category'),
		// 		'child_category'  => Input::get('child_category')));
		$categories = BmCategory::where('user_id', $user->id)
		->where('parent_category', Input::get('parent_category'))
		->where('child_category' , Input::get('child_category'))->delete();
		return Response::json(array('status'=>'success'));
		}
		
	}

	public function setCategories()
	{
		$rules = array(
		    //'user_id'       => 'required|integer|exists:users,id',
		    // 'parent_categories'  => 'required|alpha_dash|max:50|array',
		    // 'child_categories'   => 'required|alpha_dash|max:50|array',

		);
		$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else{

			$user = Auth::user();
			$parent_categories = Input::get('parent_categories');
			$child_categories  = Input::get('child_categories');

			foreach ($parent_categories as $index => $pcat) {
				$profile = BmCategory::firstOrCreate(array('user_id' => $user->id,
				'parent_category' => $pcat,
				'child_category'  => $child_categories[$index]));
			}

			
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
	}
}