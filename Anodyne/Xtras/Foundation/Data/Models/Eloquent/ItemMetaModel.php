<?php namespace Xtras\Foundation\Data\Models\Eloquent;

use Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ItemMetaModel extends Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'items_meta';

	protected $fillable = ['item_id', 'installation', 'history', 'image1', 'image2',
		'image3'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Foundation\Data\Presenters\ItemMetaPresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public static $relationsData = [
		'item' => [self::BELONGS_TO, 'ItemModel'],
	];

}