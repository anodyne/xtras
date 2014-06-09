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

	public static $relationsData = [
		'item'	=> [self::BELONGS_TO, 'ItemModel'],
		'user'	=> [self::BELONGS_TO, 'UserModel'],
	];

}