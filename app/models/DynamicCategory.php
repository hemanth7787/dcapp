<?php
class DynamicCategory extends Eloquent{
	protected $table = 'dynamic_categories';
	protected $guarded = array('id');


	public function parent()
	{
		return $this->belongsTo('DynamicCategory','parent_id');
	}

}