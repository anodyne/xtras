<?php namespace Xtras\Data\Models;

use Date, Model, SoftDeletingTrait;
use Laracasts\Presenter\PresentableTrait;

class ItemMessage extends Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'items_messages';

	protected $fillable = ['item_id', 'type', 'content', 'expires'];

	protected $dates = ['expires', 'created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Data\Presenters\ItemMessagePresenter';

	protected $touches = ['item'];

	public static $sanitizeRules = [
		'item_id'	=> 'integer',
		'type'		=> 'string',
		'content'	=> 'string',
		'expires'	=> 'date',
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

	/*
	|---------------------------------------------------------------------------
	| Model Scopes
	|---------------------------------------------------------------------------
	*/

	public function scopeActive($query)
	{
		$query->where('expires', '>=', Date::now()->startOfDay());
	}

	public function scopeItem($query, $item)
	{
		$query->where('item_id', $item);
	}

}