<?php namespace Xtras\Models\Eloquent;

use Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ItemMetaModel extends Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'items_meta';

	protected $fillable = ['item_id', 'installation'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Presenters\ItemMetaPresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function item()
	{
		return $this->belongsTo('ItemModel');
	}

}