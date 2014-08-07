<?php namespace Xtras\Foundation\Data\Models\Eloquent;

use Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ItemFileModel extends Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'items_files';

	protected $fillable = ['item_id', 'filename', 'version'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Foundation\Data\Presenters\ItemFilePresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public static $relationsData = [
		'item' => [self::BELONGS_TO, 'ItemModel'],
		'orders' => [self::HAS_MANY, 'OrderModel', 'foreignKey' => 'file_id'],
	];

}