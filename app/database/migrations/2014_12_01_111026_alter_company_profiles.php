<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCompanyProfiles extends Migration {

	public function up()
	{
		Schema::table('company_profile', function(Blueprint $table)
		{
			$table->string('region',150)->nullable();
			$table->integer('region_id')->nullable();
		});
	}

}
