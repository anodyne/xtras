<?php namespace Xtras\Models\Eloquent;

use Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TypeModel extends Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'types';

	protected $fillable = ['name'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Presenters\TypePresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function items()
	{
		return $this->hasMany('ItemModel', 'type_id');
	}

}