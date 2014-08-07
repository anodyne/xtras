<?php namespace Xtras\Foundation\Data\Models\Eloquent;

use Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ItemMessageModel extends Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'items_messages';

	protected $fillable = ['item_id', 'type', 'content', 'expires'];

	protected $dates = ['expires', 'created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Foundation\Data\Presenters\ItemMessagePresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public static $relationsData = [
		'item' => [self::BELONGS_TO, 'ItemModel'],
	];

	/*
	|---------------------------------------------------------------------------
	| Model Scopes
	|---------------------------------------------------------------------------
	*/

	public function scopeItem($query, $item)
	{
		$query->where('item_id', $item);
	}

}