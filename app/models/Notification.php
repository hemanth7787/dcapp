<?php
class Notification extends Eloquent{

	// can specify table name like this unless you got it right.
	// without below line laravel will look into table company_profiles
	protected $table = 'notifications';
	//protected $fillable = array('user_id');
	protected $guarded = array('id');


	public function user(){
		return $this->belongsTo('User');
	}
	public function scopeIdDescending($query)
    {
        return $query->orderBy('id', 'DESC');
    }
    public function fromUser()
    {
		return $this->belongsTo('User','from_user');
	} 
}