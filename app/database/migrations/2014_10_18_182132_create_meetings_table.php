<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('meetings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('from')->unsigned();
			$table->integer('to')->unsigned();
			$table->dateTime('timing_one');
			$table->dateTime('timing_two')->nullable();
			$table->dateTime('timing_three')->nullable();
			$table->boolean('confirmed')->default(false);
			$table->dateTime('confirmed_timing')->nullable();
			$table->string('optional_msg',200)->nullable();
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
		Schema::drop('meetings');
	}

}
