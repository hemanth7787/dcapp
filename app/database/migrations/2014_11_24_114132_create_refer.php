<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefer extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('refer', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('from_uid')->unsigned();
			$table->integer('to_uid')->unsigned();
			$table->integer('item_id')->unsigned();
            $table->string('item_type',20);
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
		Schema::drop('refer');
	}

}
