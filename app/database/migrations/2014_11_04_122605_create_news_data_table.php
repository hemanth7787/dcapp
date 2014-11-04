<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news_data', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('newsTitle');
			$table->text('imageURL');
			$table->text('newsURL');
			$table->text('newsDesc');
			$table->text('newsDetail');
			$table->string('newsDate');
			$table->timestamps();
			//
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('news_data', function(Blueprint $table)
		{
			//
		});
	}

}
