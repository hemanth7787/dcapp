<?php
class BusinessMatching extends Eloquent{
	protected $guarded = array('id');
	//not needed since table name followed convention
	//protected $table = 'business_matchings';

		public function user(){
		return $this->belongsTo('User');
	}
}