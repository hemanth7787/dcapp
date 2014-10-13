<?php

class UserTableSeeder extends Seeder
{
	public function run(){
		DB::table('users')->delete();
		User::create(array(
			'name' => 'hemanth kumar',
			'username' => 'hemanth7787',
			'email' => 'hemanth7787@gmail.com',
			'password' => Hash::make('hemanth7787'),
			)
		);
	}
}