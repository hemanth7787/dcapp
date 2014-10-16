<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyProfileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company_profile', function(Blueprint $table)
		{
			$table->increments('id');
			//user foreign key
			$table->integer('user_id');
			$table->string('company_name', 100);
			$table->string('designation', 100);
			$table->string('company_email', 100);
			$table->string('membership_number', 100);
			$table->string('trade_license_number', 100);
			$table->boolean('verified');
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
		Schema::drop('company_profile');
	}

}
