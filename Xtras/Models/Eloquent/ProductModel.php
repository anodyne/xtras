<?php namespace Xtras\Models\Eloquent;

use Model;
use Laracasts\Presenter\PresentableTrait;

class ProductModel extends Model {

	use PresentableTrait;

	protected $softDelete = true;

	protected $table = 'products';

	protected $fillable = ['name', 'desc'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Presenters\ProductPresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function items()
	{
		return $this->hasMany('ItemModel', 'product_id');
	}

}