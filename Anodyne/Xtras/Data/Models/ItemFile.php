<?php namespace Xtras\Data\Models;

use Model, SoftDeletingTrait;
use Laracasts\Presenter\PresentableTrait;

class ItemFile extends Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'items_files';

	protected $fillable = ['item_id', 'filename', 'version', 'size'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Data\Presenters\ItemFilePresenter';

	protected $touches = ['item'];

	public static $sanitizeRules = [
		'item_id'	=> 'integer',
		'filename'	=> 'string',
		'version'	=> 'string',
		'size'		=> 'integer',
	];

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

	/**
	 * Is the file for the latest version of the item?
	 *
	 * @return	bool
	 */
	public function isLatest()
	{
		return $this->version == $this->item->version;
	}

}