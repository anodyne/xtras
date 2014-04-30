<?php namespace Xtras\Models\Eloquent;

use Model;
use Laracasts\Presenter\PresentableTrait;

class ItemMessageModel extends Model {

	use PresentableTrait;

	protected $softDelete = true;

	protected $table = 'items_messages';

	protected $fillable = ['item_id', 'type', 'content', 'expires'];

	protected $dates = ['expires', 'created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Presenters\ItemMessagePresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function item()
	{
		return $this->belongsTo('ItemModel');
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