<?php
class DccomProfile extends Eloquent{
	protected $table = 'dccom_profiles';
	protected $guarded = array('id');

		public function user(){
		return $this->belongsTo('User');
	}
}