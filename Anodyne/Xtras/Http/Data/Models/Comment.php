<?php namespace Xtras\Data\Models;

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

}