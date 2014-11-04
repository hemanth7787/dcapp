<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events_data', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('eventTitle');
			$table->text('eventURL');
			$table->text('eventDesc');
			$table->string('eventDate');
			$table->string('eventAboutTitle');
			$table->text('eventAboutDesc');
			$table->string('eventAgendaTitle');
			$table->text('eventAgendaDesc');
			$table->string('eventSpeakerTitle');
			$table->text('eventSpeakerDesc');
			$table->text('eventImgURL');
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
		Schema::table('events_data', function(Blueprint $table)
		{
			//
		});
	}

}
