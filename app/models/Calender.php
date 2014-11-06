<?php
class Calender extends Eloquent{
	protected $table = 'calender';
	protected $guarded = array('id');

	public function user()
	{
		return $this->belongsTo('User');
	}
	
	public function scopeIdDescending($query)
    {
        return $query->orderBy('id', 'DESC');
    } 
}