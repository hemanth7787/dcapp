<?php

class AdminCategoryController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$categories = DynamicCategory::all();
		return View::make('admin.category.index')->with('categories',$categories);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$categories = DynamicCategory::all()->lists('name','id');
		return View::make('admin.category.create')->with('categories',$categories);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$categories = DynamicCategory::all();
		$category_list = $categories->lists('name','id');
		$rules = array(
		    'name'  => 'required',
		    'slug'  => 'required|alpha_dash',
		    'parent_category'  => 'required|exists:dynamic_categories,id',
		);
		$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
				Input::flash();
				return View::make('admin.category.create')
				->with('categories',$category_list)
                ->with('errors', $validator->messages());
		}
		else
		{
			//need special validation here, shud not contain 
			//child categories with same slug on same level of the tree.
			$parent_cat=$categories->find(Input::get('parent_category'));
			$cat = new DynamicCategory();
			$cat->name = Input::get('name');
			$cat->slug = Input::get('slug');
			$cat->parent_id   = $parent_cat->id;
			$cat->parent_slug = $parent_cat->slug;
			$cat->save();
			return Redirect::to('account');
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$item = DynamicCategory::find($id);
		return View::make('admin.category.show')
		->with('item',$item);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$categories = DynamicCategory::all();
		$category_list = $categories->lists('name','id');
		$item = $categories->find($id);

		return View::make('admin.category.edit')
		->with('categories',$category_list)
		->with('item',$item);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$categories = DynamicCategory::all();
		$category_list = $categories->lists('name','id');
		$item = $categories->find($id);
		$rules = array(
		    'name'  => 'required',
		    'slug'  => 'required|alpha_dash',
		    'parent_category'  => 'required|exists:dynamic_categories,id',
		);
		$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) {
				return View::make('admin.category.create')
				->with('categories',$category_list)
				->with('item',$item)
                ->with('errors', $validator->messages());
		}
		else
		{
			//need special validation here, shud not contain 
			//child categories with same slug on same level of the tree.
			$parent_cat=$categories->find(Input::get('parent_category'));
			$cat = $item;
			$cat->name = Input::get('name');
			$cat->slug = Input::get('slug');
			$cat->parent_id   = $parent_cat->id;
			$cat->parent_slug = $parent_cat->slug;
			$cat->save();
			//return Redirect::to('admin/category')->withId($item->id);
			return Redirect::route('admin.category.show',$cat->id);
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$item = DynamicCategory::find($id);
		$item->delete();

		return Redirect::to('admin/category');
    }

}
