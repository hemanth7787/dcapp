<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookmarkTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bookmarks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title',50);
			$table->integer('item_id')->unsigned();
			$table->string('item_type',2); //EV - event, ME - meeting, GE - general etc
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
		Schema::drop('bookmarks');
	}

}
