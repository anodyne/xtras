<?php namespace Xtras\Data\Models;

use Model, SoftDeletingTrait;
use Laracasts\Presenter\PresentableTrait;

class ItemMetadata extends Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'items_metadata';

	protected $fillable = ['item_id', 'installation', 'history', 'image1', 'image2',
		'image3', 'thumbnail1', 'thumbnail2', 'thumbnail3'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Data\Presenters\ItemMetadataPresenter';

	public static $sanitizeRules = [
		'item_id'		=> 'integer',
		'installation'	=> 'string',
		'history'		=> 'string',
		'image1'		=> 'string',
		'image2'		=> 'string',
		'image3'		=> 'string',
		'thumbnail1'	=> 'string',
		'thumbnail2'	=> 'string',
		'thumbnail3'	=> 'string',
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

}