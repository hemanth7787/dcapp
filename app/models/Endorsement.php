<?php
class Endorsement extends Eloquent{
	protected $table = 'endorsements';
	protected $guarded = array('id');

	public function user()
	{
		return $this->belongsTo('User','to');
	}
	public function scopeIdDescending($query)
    {
        return $query->orderBy('id', 'DESC');
    } 
}
