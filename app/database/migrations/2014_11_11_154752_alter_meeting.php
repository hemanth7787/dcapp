<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMeeting extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{		Schema::table('meetings', function($table)
        {
            $table->dropColumn('timing_one');
            $table->dateTime('timing')->nullable();
            $table->integer('msg_target_usr_id')->unsigned();
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
