<?php namespace Xtras\Foundation\Data\Models\Eloquent;

use Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ProductModel extends Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'products';

	protected $fillable = ['name', 'desc', 'display'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Foundation\Data\Presenters\ProductPresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function items()
	{
		return $this->hasMany('ItemModel', 'product_id');
	}

	/*
	|---------------------------------------------------------------------------
	| Model Scopes
	|---------------------------------------------------------------------------
	*/

	public function scopeActive($query)
	{
		$query->where('display', (int) true);
	}

}