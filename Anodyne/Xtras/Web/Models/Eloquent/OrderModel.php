<?php namespace Xtras\Models\Eloquent;

use Model;

class OrderModel extends Model {

	protected $connection = 'mysql';

	protected $table = 'orders';

	protected $fillable = ['user_id', 'item_id', 'file_id', 'notify'];

	protected $dates = ['created_at', 'updated_at'];

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public static $relationsData = [
		'item'	=> [self::BELONGS_TO, 'ItemModel'],
		'file'	=> [self::BELONGS_TO, 'ItemFileModel'],
		'user'	=> [self::BELONGS_TO, 'UserModel'],
	];

}