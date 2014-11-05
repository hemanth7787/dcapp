<?php
class Bookmark extends Eloquent{
	protected $table = 'bookmarks';
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
