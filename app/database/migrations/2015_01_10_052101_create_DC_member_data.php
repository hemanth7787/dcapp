<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDCMemberData extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('DC_member_data', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('MemberNumber', 50)->nullable();
			$table->string('MemberNameEN', 300)->nullable();
			$table->string('MemberEmail', 100)->nullable();
			$table->string('MemberPhone', 100)->nullable();
			$table->string('BuildingStreet', 200)->nullable();
			$table->string('BuildingArea', 200)->nullable();
			$table->string('City', 100)->nullable();
			$table->string('extra_data_activityCode', 200)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('DC_member_data');
	}

}
