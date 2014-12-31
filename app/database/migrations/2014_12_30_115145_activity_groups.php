<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivityGroups extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activity_groups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code', 30);
			$table->string('name_en', 500)->nullable();
			$table->string('name_ar', 500)->nullable();
			$table->string('superset', 30)->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('activity_groups');
	}

}
