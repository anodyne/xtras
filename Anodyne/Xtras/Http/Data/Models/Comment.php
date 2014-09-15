<?php namespace Xtras\Data\Models;

use Sanitize;
use Laracasts\Presenter\PresentableTrait;

class Comment extends \Model {

	use PresentableTrait;

	protected $table = 'comments';

	protected $fillable = ['user_id', 'item_id', 'content'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = 'Xtras\Data\Presenters\CommentPresenter';

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

	/*
	|---------------------------------------------------------------------------
	| Accessors/Mutators
	|---------------------------------------------------------------------------
	*/

	public function setContentAttribute($value)
	{
		$this->attributes['content'] = Sanitize::string($value);
	}

	public function setItemIdAttribute($value)
	{
		$this->attributes['item_id'] = Sanitize::integer($value);
	}

	public function setUserIdAttribute($value)
	{
		$this->attributes['user_id'] = Sanitize::integer($value);
	}

}