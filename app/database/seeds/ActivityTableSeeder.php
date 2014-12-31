<?php
//http://stackoverflow.com/questions/9139202/how-to-parse-a-csv-file-using-php
class ActivityTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('activity_groups')->delete();
		DB::table('activity_classes')->delete();
		DB::table('activity_codes')->delete();

		$this->dynamicCategorySeed();
	}

	private function dynamicCategorySeed()
	{

		$this->createGroups('/misc/csv/activity/Activity_groups.csv');
		$this->createClasses('/misc/csv/activity/Activity_classes.csv');

		$this->createCodes('/misc/csv/activity/ActivityList_details.csv');
		$this->createCodes('/misc/csv/activity/ActivityList_details_2.csv');
		$this->createCodes('/misc/csv/activity/ActivityList_details_3.csv');
		$this->createCodes('/misc/csv/activity/ActivityList_details_4.csv');
		$this->createCodes('/misc/csv/activity/ActivityList_details_5.csv');

		$this->createCodes('/misc/csv/activity/ActivityList_details_6.csv');
		$this->createCodes('/misc/csv/activity/ActivityList_details_7.csv');
		$this->createCodes('/misc/csv/activity/ActivityList_details_8.csv');
		$this->createCodes('/misc/csv/activity/ActivityList_details_9.csv');
		$this->createCodes('/misc/csv/activity/ActivityList_details_10.csv');

		$this->createCodes('/misc/csv/activity/ActivityList_details_11.csv');
		$this->createCodes('/misc/csv/activity/ActivityList_details_12.csv');
		$this->createCodes('/misc/csv/activity/ActivityList_details_13.csv');

	}

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
			    	ActivityGroup::create(array(
					'code' => $data[0],
					'name_en' => $data[1],
					'name_ar'    => $data[2],
					'superset' => substr($data[0], 0,3)
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

	private function createClasses($file)
	{
		{
			echo "\n---------[Creating activity classes]-------------";
			$csv = base_path().$file;
			$row = 1;
			if (($handle = fopen($csv, "r")) !== FALSE) {
			  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			    $row++;
			    if(strlen($data[0])==5)
			    {
			    	echo  "\n Create ".$data[0]." -- ".$data[1]." -- ".$data[2];
			    	ActivityClass::create(array(
					'code' => $data[0],
					'name_en' => $data[1],
					'name_ar'    => $data[2],
					'superset' => substr($data[0], 0,4)
					));
			    }
			    else
			    $e=  "\n"."Omitted: ".$data[0]." -- ".$data[1]." -- ".$data[2];
			  }
			  fclose($handle);
			}
		}
	}

	private function createCodes($file)
	{
		$bulk_code_array = array();
		echo "\n---------[Creating activity codes]-------------";
		$csv = base_path().$file;
		$row = 1;
		if (($handle = fopen($csv, "r")) !== FALSE) {
		  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		    // $num = count($data);
		    // echo "<p> $num fields in line $row: <br /></p>\n";
		    $row++;
		    // for ($c=0; $c < $num; $c++) {
		    //     echo $data[$c] . "<br />\n";
		    // }
		    $le = strlen($data[0]);
		    if($le == 7||$le == 6||$le == 8)
		    {
		    	//echo  "\n Create ".$data[0]." -- ".$data[1]." -- ".$data[2];
		    	$bulk_code_array[]= array(
					'code' => $data[0],
					'name_en' => $data[1],
					'name_ar'    => $data[2],
					'superset' => substr($data[0], 0,5)
				);
		    }
			else
			{
				$e= "\n"."$le Omitted: ".$data[0]." -- ".$data[1]." -- ".$data[2];
			}

			if($row%1000 == 0)
			{
				ActivityCodeModel::insert($bulk_code_array);
				$bulk_code_array=array();
			}
		  }
		  ActivityCodeModel::insert($bulk_code_array);
		  fclose($handle);
		}
	}

}

