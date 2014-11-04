<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableNotifications extends Migration {

	public function up()
	{
		Schema::table('notifications', function($table)
        {
            $table->integer('user_id')->unsigned();
        });


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('notifications', function($table)
        {
            $table->dropColumn('user_id');
        });
	}

}
