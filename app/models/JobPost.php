<?php
class JobPost extends Eloquent{
	protected $table = 'job_posts';
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