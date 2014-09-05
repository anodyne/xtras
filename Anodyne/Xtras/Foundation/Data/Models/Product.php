<?php namespace Xtras\Foundation\Data\Models;

use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Product extends \Model {

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
		return $this->hasMany('Item');
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