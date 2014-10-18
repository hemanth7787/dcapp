<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalenderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('calender', function(Blueprint $table)
		{
			$table->increments('id');
			$table->dateTime('date');
			$table->integer('item_id')->unsigned();
			$table->string('item_type',2); // EV - event, ME - meeting
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
		Schema::drop('calender');
	}

}
