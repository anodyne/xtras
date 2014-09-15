<?php namespace Xtras\Data\Models;

use Model, Sanitize;
use Laracasts\Presenter\PresentableTrait;

class Comment extends Model {

	use PresentableTrait;

	protected $table = 'comments';

	protected $fillable = ['user_id', 'item_id', 'content'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = 'Xtras\Data\Presenters\CommentPresenter';

	public static $sanitizeRules = [
		'user_id'	=> 'integer',
		'item_id'	=> 'integer',
		'content'	=> 'string',
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

	public function user()
	{
		return $this->belongsTo('User');
	}

}