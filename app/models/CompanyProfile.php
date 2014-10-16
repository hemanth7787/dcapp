<?php
class CompanyProfile extends Eloquent{

	// can specify table name like this unless you got it right.
	// without below line laravel will look into table company_profiles
	protected $table = 'company_profile';


	public function user(){
		return $this->belongsTo('User');
	}
}

// $user = User::find(10);
// $profile = $user->UserProfile ?: new UserProfile;
// $profile->name = 'Steven';
// $user->UserProfile()->save($profile);