<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDynamicCategory extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dynamic_categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',100)->nullable();
			$table->string('slug',100)->nullable();
			$table->integer('parent_id')->unsigned();
			$table->string('parent_slug',100)->nullable();
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
		Schema::drop('dynamic_categories');
	}

}
