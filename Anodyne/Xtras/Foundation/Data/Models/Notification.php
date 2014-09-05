<?php namespace Xtras\Foundation\Data\Models;

class Notification extends \Model {

	public $timestamps = false;

	protected $table = 'notifications';

	protected $fillable = ['user_id', 'item_id'];

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function item()
	{
		return $this->belongsTo('Item');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

}