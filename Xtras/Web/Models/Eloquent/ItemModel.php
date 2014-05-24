<?php namespace Xtras\Models\Eloquent;

use Str,
	Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ItemModel extends Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'items';

	protected $fillable = ['user_id', 'type_id', 'product_id', 'name', 'desc',
		'support'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Presenters\ItemPresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function product()
	{
		return $this->belongsTo('ProductModel');
	}

	public function type()
	{
		return $this->belongsTo('TypeModel');
	}

	public function user()
	{
		return $this->belongsTo('UserModel');
	}

	public function messages()
	{
		return $this->hasMany('ItemMessageModel', 'item_id');
	}

	public function meta()
	{
		return $this->hasOne('ItemMetaModel', 'item_id');
	}

	public function ratings()
	{
		return $this->hasMany('ItemRatingModel', 'item_id');
	}

	public function comments()
	{
		return $this->hasMany('CommentModel', 'item_id');
	}

	public function orders()
	{
		return $this->hasMany('OrderModel', 'item_id');
	}

}