<?php namespace Xtras\Data\Models;

use Model, SoftDeletingTrait;
use Laracasts\Presenter\PresentableTrait;

class Product extends Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'products';

	protected $fillable = ['name', 'desc', 'display'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Data\Presenters\ProductPresenter';

	public static $sanitizeRules = [
		'name'		=> 'string',
		'desc'		=> 'string',
		'display'	=> 'integer',
	];

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