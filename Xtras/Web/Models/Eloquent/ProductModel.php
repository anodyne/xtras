<?php namespace Xtras\Models\Eloquent;

use Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProductModel extends Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'products';

	protected $fillable = ['name', 'desc'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Presenters\ProductPresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public static $relationsData = [
		'items' => [self::HAS_MANY, 'ItemModel', 'foreignKey' => 'product_id'],
	];

}