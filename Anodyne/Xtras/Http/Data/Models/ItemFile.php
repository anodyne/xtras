<?php namespace Xtras\Data\Models;

use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ItemFile extends \Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'items_files';

	protected $fillable = ['item_id', 'filename', 'version', 'size'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Data\Presenters\ItemFilePresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function item()
	{
		return $this->belongsTo('Item');
	}

	public function orders()
	{
		return $this->hasMany('Order');
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