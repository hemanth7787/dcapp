<?php

class BusinessMatchingController extends \BaseController {

	// Seperate table
	public function getCategoryList()
	{
		$user = Auth::user();
		$items = $this->userCategories($user);
		return Response::json(array('root'=>$items));
	}

	public function deleteCategories()
	{
		$rules = array(
		    'category_ids'  => 'required|array',
		);
		$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else
		{

		$user = Auth::user();
		$categories = BmCategory::where('user_id','=',$user->id)
		->whereIn('category_id', Input::get('category_ids'))->get();
		$count=0;
		foreach ($categories as $category)
		{
			$category->delete();
			$count++;
		}
		$items = $this->userCategories($user);
		return Response::json(array('status'=>'success','deleted_items'=>$count,'root'=>$items));
		}
	}

	public function setCategories()
	{
		$rules = array(
		    'category_ids'  => 'required|array',
		);
		$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
			return Response::json(array('errors' => $validator->messages(),'status'=>'failed'));
		}
		else{

			$user = Auth::user();
			$categories = DynamicCategory::find(Input::get('category_ids'));

			$count=0;
			foreach ($categories as $category) {
				$profile = BmCategory::firstOrCreate(array(
				'user_id' => $user->id,
				'category_id' => $category->id,
				'category_name'  => $category->name,
				'category_slug'  => $category->slug
				));
				$count++;
			}
			$items = $this->userCategories($user);
			return Response::json(array('status'=>'success','added_items'=>$count,'root'=>$items));
		}
	}

    // PRIVATE
	private function userCategories($user)
	{
			$usr_selected_categories = $user->categories;
			$usrcat_id_array = array();

			foreach ($usr_selected_categories as $usr_cat) 
			{
				$usrcat_id_array[] = $usr_cat->category_id;
			}

			$categories = DynamicCategory::where('parent_slug','root')->get();
			$items=array();
			foreach ($categories as $category) 
			{
				$items[] = array(
					'id' => $category->id,
					'name' => $category->name,
					'slug' => $category->slug,
					'selected' => in_array($category->id, $usrcat_id_array), // true if user selected
					'parent_id'   => $category->parent_id,
					'parent_slug' => $category->parent_slug
					);
			}
			return $items;
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