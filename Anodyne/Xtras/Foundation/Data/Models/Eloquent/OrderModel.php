<?php namespace Xtras\Foundation\Data\Models\Eloquent;

use Model;

class OrderModel extends Model {

	protected $table = 'orders';

	protected $fillable = ['user_id', 'item_id', 'file_id', 'notify'];

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

	public function file()
	{
		return $this->belongsTo('ItemFileModel');
	}

	public function user()
	{
		return $this->belongsTo('UserModel');
	}

}