<?php namespace Xtras\Foundation\Data\Models\Eloquent;

use Model;
use Laracasts\Presenter\PresentableTrait;

class CommentModel extends Model {

	use PresentableTrait;

	protected $table = 'comments';

	protected $fillable = ['user_id', 'item_id', 'content'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = 'Xtras\Foundation\Data\Presenters\CommentPresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public static $relationsData = [
		'item' => [self::BELONGS_TO, 'ItemModel'],
		'user' => [self::BELONGS_TO, 'UserModel'],
	];

}