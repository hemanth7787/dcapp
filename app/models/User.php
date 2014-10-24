<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function profile()
	{
		return $this->hasOne('CompanyProfile');
	}

	public function business()
	{
		return $this->hasOne('BusinessMatching');
	}
	
	public function categories()
	{
		return $this->hasMany('BmCategory');
	}

	public function social()
	{
		return $this->hasOne('SocialAccount');
	}

	public function dccomprofile()
	{
		return $this->hasOne('SocialAccount');
	}

}
