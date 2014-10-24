<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDccomProfileTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dccom_profiles', function(Blueprint $table)
		{
		//  <MEMBER_NO>1298</MEMBER_NO>
 		//  <MEMBER_NAME_EN>DUBAI CHAMBER PROD. TEST</MEMBER_NAME_EN>
 		//  <MEMBER_NAME_AR>غرفة دبي</MEMBER_NAME_AR> 
 		//  <MEMBER_TYPE>Member</MEMBER_TYPE> 
 		//  <MEMBER_STATUS>Active</MEMBER_STATUS> 
 		//  <ADDRESS1>ALYASMEN</ADDRESS1>
 		//  <PO_BOX>1457</PO_BOX> 
 		//  <CITY>DUBAI</CITY> 
 		//  <AREA>Umm Suqeim, 3rd</AREA> 
 		//  <STREET>Abu Hail Street</STREET> 
	 	//  <PHONE>+972 0450552</PHONE> 
 		//  <CONTACT_NAME>MOBILEUSER</CONTACT_NAME> 
 		//  <LOGIN>MOBILEUSER</LOGIN> 
 		//  <EMAIL_ADDR>is_vikas_mishra@dubaichamber.com</EMAIL_ADDR> 
 		//  <X_MEMBER_EXPIRY_DT>01-JUL-17</X_MEMBER_EXPIRY_DT> 
			$table->increments('id');
			//FKEY
			$table->integer('user_id')->unsigned();
			$table->integer('MEMBER_NO');
			$table->string('MEMBER_NAME_EN',200);
			$table->string('MEMBER_NAME_AR',200);
			$table->string('MEMBER_TYPE',20);
			$table->string('MEMBER_STATUS',20);
			$table->string('ADDRESS1',100);
			$table->string('PO_BOX',20);
			$table->string('CITY',50);
			$table->string('AREA',50);
			$table->string('STREET',50);
			$table->string('PHONE',50);
			$table->string('CONTACT_NAME',100);
			$table->string('LOGIN',50);
			$table->string('EMAIL_ADDR', 100);
			$table->string('X_MEMBER_EXPIRY_DT', 20);
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
		Schema::drop('dccom_profiles');
	}

}
