<?php

class DynamicCategorySeeder extends Seeder
{
	public function run()
	{
		DB::table('dynamic_categories')->delete();
		$root = DynamicCategory::firstOrCreate(array(
			'name' => 'root',
			'slug' => 'root',
			'parent_id'    => 0,
			// 'parent_slug' => 'root'),
			)
		);

		$this->dynamicCategorySeed($root);
	}

	private function dynamicCategorySeed($root)
	{
		/* Energy,Materials,Capital Goods,Commercial & Porfessional Services,Transportation,Automobiles & Components,Consumer Durables & Apparels,Hotels Restaurants & Leisure,Media,Aviation*/

		$this->create(array('name'=>'Energy','slug' =>'energy',
		 'parent_id'=>$root->id, 'parent_slug' => $root->slug));
		$this->create(array('name'=>'Materials','slug' =>'materials',
		 'parent_id'=>$root->id, 'parent_slug' => $root->slug));
		$this->create(array('name'=>'Capital Goods','slug' =>'capital-goods',
		 'parent_id'=>$root->id, 'parent_slug' => $root->slug));
		$this->create(array('name'=>'Commercial & Professional Services','slug' =>'commercial-professional-services',
		 'parent_id'=>$root->id, 'parent_slug' => $root->slug));
		$this->create(array('name'=>'Transportation','slug' =>'transportation',
		 'parent_id'=>$root->id, 'parent_slug' => $root->slug));

		$this->create(array('name'=>'Automobiles & Components','slug' =>'automobiles-components',
		 'parent_id'=>$root->id, 'parent_slug' => $root->slug));
		$this->create(array('name'=>'Consumer Durables & Apparels','slug' =>'consumer-durables-apparels',
		 'parent_id'=>$root->id, 'parent_slug' => $root->slug));
		$this->create(array('name'=>'Hotels Restaurants & Leisure','slug' =>'hotels-restaurants-leisure',
		 'parent_id'=>$root->id, 'parent_slug' => $root->slug));
		$this->create(array('name'=>'Media','slug' =>'media',
		 'parent_id'=>$root->id, 'parent_slug' => $root->slug));
		$this->create(array('name'=>'Aviation','slug' =>'aviation',
		 'parent_id'=>$root->id, 'parent_slug' => $root->slug));

	}

	private function create($arr)
	{
			DynamicCategory::create(array(
			'name' => $arr['name'],
			'slug' => $arr['slug'],
			'parent_id'    => $arr['parent_id'],
			'parent_slug' => $arr['parent_slug']
			));
	}

}