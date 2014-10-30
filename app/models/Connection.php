<?php
class Connection extends Eloquent{
	protected $table = 'my_connections';
	protected $guarded = array('id');

	public function initiator()
	{
		return $this->belongsTo('User','from');
	}

	public function receiver()
	{
		return $this->belongsTo('User','to');
	}
}