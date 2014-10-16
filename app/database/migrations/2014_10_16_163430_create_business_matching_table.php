<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessMatchingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('business_matchings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('provides', 10); // products,services,both
			$table->integer('employee_count');
			$table->integer('annual_turnover');
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
		Schema::drop('business_matchings');
	}

}
