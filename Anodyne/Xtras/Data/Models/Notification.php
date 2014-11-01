<?php namespace Xtras\Data\Models;

use Model;

class Notification extends Model {

	public $timestamps = false;

	protected $table = 'notifications';

	protected $fillable = ['user_id', 'item_id'];

	public static $sanitizeRules = [
		'item_id'	=> 'integer',
		'user_id'	=> 'integer',
	];

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