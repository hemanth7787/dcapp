<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBmCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{		Schema::table('bm_categories', function($table)
        {
			$table->dropColumn('parent_category');
			$table->dropColumn('child_category');
			$table->integer('category_id')->unsigned();
			$table->string('category_name', 100);
			$table->string('category_slug', 100);
        });

	}
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
