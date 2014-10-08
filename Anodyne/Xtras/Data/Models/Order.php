<?php namespace Xtras\Data\Models;

use Model;
use Laracasts\Presenter\PresentableTrait;

class Order extends Model {

	use PresentableTrait;

	protected $table = 'orders';

	protected $fillable = ['user_id', 'item_id', 'file_id'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = 'Xtras\Data\Presenters\OrderPresenter';

	public static $sanitizeRules = [
		'file_id'	=> 'integer',
		'item_id'	=> 'integer',
		'user_id'	=> 'integer',
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

	public function file()
	{
		return $this->belongsTo('ItemFile');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

}