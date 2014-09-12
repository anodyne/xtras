<?php namespace Xtras\Data\Models;

use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ItemMessage extends \Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'items_messages';

	protected $fillable = ['item_id', 'type', 'content', 'expires'];

	protected $dates = ['expires', 'created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Data\Presenters\ItemMessagePresenter';

	protected $touches = ['item'];

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function item()
	{
		return $this->belongsTo('Item');
	}

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