<?php namespace Xtras\Data\Models;

use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Type extends \Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'types';

	protected $fillable = ['name', 'display'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Data\Presenters\TypePresenter';

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

	public function scopeName($query, $name)
	{
		$query->where('name', $name);
	}

}