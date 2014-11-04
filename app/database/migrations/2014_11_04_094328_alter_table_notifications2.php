<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableNotifications2 extends Migration {

	public function up()
	{
		Schema::table('notifications', function($table)
        {
        	$table->dropColumn('item_type');
            $table->boolean('read')->default(false);
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
