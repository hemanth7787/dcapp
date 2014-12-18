<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterJobPosts extends Migration {

	public function up()
	{
		Schema::table('job_posts', function(Blueprint $table)
		{
			$table->string('title', 100);
			$table->dateTime('due_date')->nullable();
		});
	}

}
