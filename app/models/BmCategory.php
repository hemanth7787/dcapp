<?php
class BmCategory extends Eloquent{
	protected $table = 'bm_categories';
	protected $guarded = array('id');

		public function user(){
		return $this->belongsTo('User');
	}
}