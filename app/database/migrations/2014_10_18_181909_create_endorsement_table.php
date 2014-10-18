<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEndorsementTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('endorsements', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('from_user')->unsigned();
			$table->integer('to_user')->unsigned();
			$table->text('optional_msg')->nullable();
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
		Schema::drop('endorsements');
	}

}
