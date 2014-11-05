<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBookmarks extends Migration {

	public function up()
	{
		Schema::table('bookmarks', function($table)
        {
            $table->dropColumn('item_type');
            $table->integer('user_id')->unsigned();
            $table->string('item_id_type',20)->nullable();
            $table->string('item_parameter',20)->nullable();
            $table->string('item_param_type',20)->nullable();
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
