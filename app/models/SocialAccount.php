<?php
class SocialAccount extends Eloquent{
	protected $table = 'social_accounts';
	protected $guarded = array('id');

		public function user(){
		return $this->belongsTo('User');
	}
}