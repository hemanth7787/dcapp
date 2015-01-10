<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDCMemberData extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('DC_member_data', function(Blueprint $table)
		{
			$table->string('MemberNameAR', 300)->nullable();
			$table->string('MemberFax', 100)->nullable();
			$table->string('BuildingNameEng', 300)->nullable();
			$table->string('BuildingNameAra', 300)->nullable();
			$table->string('BuildingNo', 50)->nullable();
			$table->string('POBox',20)->nullable();
			$table->string('Country', 100)->nullable();
			$table->string('Province', 100)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
