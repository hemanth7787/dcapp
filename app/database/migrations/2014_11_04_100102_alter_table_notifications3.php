<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableNotifications3 extends Migration {

	public function up()
	{
		Schema::table('notifications', function($table)
        {
            $table->string('item_type',10);
        });


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

	}

}
