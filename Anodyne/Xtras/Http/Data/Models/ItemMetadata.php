<?php namespace Xtras\Data\Models;

use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ItemMetadata extends \Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'items_metadata';

	protected $fillable = ['item_id', 'installation', 'history', 'image1', 'image2',
		'image3', 'thumbnail1', 'thumbnail2', 'thumbnail3'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Data\Presenters\ItemMetadataPresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function item()
	{
		return $this->belongsTo('Item');
	}

}