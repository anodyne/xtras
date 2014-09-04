<?php namespace Xtras\Foundation\Data\Models\Eloquent;

use Model;

class NotificationModel extends Model {

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
		return $this->belongsTo('ItemModel');
	}

	public function user()
	{
		return $this->belongsTo('UserModel');
	}

}