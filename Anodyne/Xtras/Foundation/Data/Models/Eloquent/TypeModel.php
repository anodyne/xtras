<?php namespace Xtras\Foundation\Data\Models\Eloquent;

use Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TypeModel extends Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'types';

	protected $fillable = ['name', 'display'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Foundation\Data\Presenters\TypePresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function items()
	{
		return $this->hasMany('ItemModel', 'type_id');
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