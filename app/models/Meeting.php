<?php
class Meeting extends Eloquent{
	protected $table = 'meetings';
	protected $guarded = array('id');

	public function requestFrom()
	{
		return $this->belongsTo('User','from');
	}
	public function requestTo()
	{
		return $this->belongsTo('User','to');
	}
	public function scopeIdDescending($query)
    {
        return $query->orderBy('id', 'DESC');
    } 
}
