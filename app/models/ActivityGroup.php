<?php
class ActivityGroup extends Eloquent{
	protected $table = 'activity_groups';
	protected $guarded = array('id');

	// public function referFrom()
	// {
	// 	return $this->belongsTo('User','from_uid');
	// }
	// public function referTo()
	// {
	// 	return $this->belongsTo('User','to_uid');
	// }
	public function scopeIdDescending($query)
    {
        return $query->orderBy('id', 'DESC');
    } 
}