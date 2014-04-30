<?php namespace Xtras\Models\Eloquent;

use Model;

class OrderModel extends Model {

	protected $table = 'orders';

	protected $fillable = ['user_id', 'item_id', 'notify'];

	protected $dates = ['created_at', 'updated_at'];

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