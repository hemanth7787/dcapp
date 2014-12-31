<?php

class DynamicCategorySeeder extends Seeder
{
	public function run()
	{
		DB::table('dynamic_categories')->delete();
		DB::table('bm_categories')->delete();
		// $root = DynamicCategory::firstOrCreate(array(
		// 	'name' => 'root',
		// 	'slug' => 'root',
		// 	'parent_id'    => 0,
		// 	// 'parent_slug' => 'root'),
		// 	)
		// );

		// $this->dynamicCategorySeed($root);
		$this->createGroups('/misc/csv/activity/Activity_groups.csv');
	}

	// private function dynamicCategorySeed($root)
	// {
	// 	/* Energy,Materials,Capital Goods,Commercial & Porfessional Services,Transportation,Automobiles & Components,Consumer Durables & Apparels,Hotels Restaurants & Leisure,Media,Aviation*/

	// 	$this->create(array('name'=>'Energy','slug' =>'energy',
	// 	 'parent_id'=>$root->id, 'parent_slug' => $root->slug));
	// 	$this->create(array('name'=>'Materials','slug' =>'materials',
	// 	 'parent_id'=>$root->id, 'parent_slug' => $root->slug));
	// 	$this->create(array('name'=>'Capital Goods','slug' =>'capital-goods',
	// 	 'parent_id'=>$root->id, 'parent_slug' => $root->slug));
	// 	$this->create(array('name'=>'Commercial & Professional Services','slug' =>'commercial-professional-services',
	// 	 'parent_id'=>$root->id, 'parent_slug' => $root->slug));
	// 	$this->create(array('name'=>'Transportation','slug' =>'transportation',
	// 	 'parent_id'=>$root->id, 'parent_slug' => $root->slug));

	// 	$this->create(array('name'=>'Automobiles & Components','slug' =>'automobiles-components',
	// 	 'parent_id'=>$root->id, 'parent_slug' => $root->slug));
	// 	$this->create(array('name'=>'Consumer Durables & Apparels','slug' =>'consumer-durables-apparels',
	// 	 'parent_id'=>$root->id, 'parent_slug' => $root->slug));
	// 	$this->create(array('name'=>'Hotels Restaurants & Leisure','slug' =>'hotels-restaurants-leisure',
	// 	 'parent_id'=>$root->id, 'parent_slug' => $root->slug));
	// 	$this->create(array('name'=>'Media','slug' =>'media',
	// 	 'parent_id'=>$root->id, 'parent_slug' => $root->slug));
	// 	$this->create(array('name'=>'Aviation','slug' =>'aviation',
	// 	 'parent_id'=>$root->id, 'parent_slug' => $root->slug));

	// }

	// private function create($arr)
	// {
	// 		DynamicCategory::create(array(
	// 		'name' => $arr['name'],
	// 		'slug' => $arr['slug'],
	// 		'parent_id'    => $arr['parent_id'],
	// 		'parent_slug' => $arr['parent_slug']
	// 		));
	// }

	private function createGroups($file)
	{
		{
			echo "\n---------[Creating activity groups]-------------";
			$csv = base_path().$file;
			$row = 1;
			if (($handle = fopen($csv, "r")) !== FALSE) {
			  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			    $row++;
			    if(strlen($data[0])==4)
			    {
			    	echo  "\n Create ".$data[0]." -- ".$data[1]." -- ".$data[2];
			        //ActivityGroup::create(array(
					// 'code' => $data[0],
					// 'name_en' => $data[1],
					// 'name_ar'    => $data[2],
					// 'superset' => substr($data[0], 0,3)
					// ));

					DynamicCategory::create(array(
					'name' => $data[1],
					'slug' => $data[0],
					'parent_id'    => 0,
					'parent_slug' => substr($data[0], 0,3)
					));
			    }
			    else
			    {
			    	echo  "\n"."Omitted: ".$data[0]." -- ".$data[1]." -- ".$data[2];
			    } 
			  }
			  fclose($handle);
			}
		}
	}
}