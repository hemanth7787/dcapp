<?php
class JobApplication extends Eloquent{
	protected $table = 'job_applications';
	protected $guarded = array('id');

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function JobPost()
	{
		return $this->belongsTo('JobPost','job_post_id');
	}
	
	public function scopeIdDescending($query)
    {
        return $query->orderBy('id', 'DESC');
    } 

}