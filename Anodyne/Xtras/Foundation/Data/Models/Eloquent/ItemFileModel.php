<?php namespace Xtras\Foundation\Data\Models\Eloquent;

use Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ItemFileModel extends Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'items_files';

	protected $fillable = ['item_id', 'filename', 'version', 'size'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Foundation\Data\Presenters\ItemFilePresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function item()
	{
		return $this->belongsTo('ItemModel');
	}

	public function orders()
	{
		return $this->hasMany('OrderModel', 'file_id');
	}

	/*
	|---------------------------------------------------------------------------
	| Model Methods
	|---------------------------------------------------------------------------
	*/

	public function isLatest()
	{
		return $this->version == $this->item->version;
	}

}