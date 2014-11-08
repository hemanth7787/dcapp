<?php
class Endorsement extends Eloquent{
	protected $table = 'endorsements';
	protected $guarded = array('id');

	public function user()
	{
		return $this->belongsTo('User','to_user');
	}
	public function fromUser()
	{
		return $this->belongsTo('User','from_user');
	}
	public function scopeIdDescending($query)
    {
        return $query->orderBy('id', 'DESC');
    } 
}
