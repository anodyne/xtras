<?php namespace Xtras\Models\Eloquent;

use Model;
use Laracasts\Presenter\PresentableTrait;

class CommentModel extends Model {

	use PresentableTrait;

	protected $table = 'comments';

	protected $fillable = ['user_id', 'item_id', 'content'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = 'Xtras\Presenters\CommentPresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function item()
	{
		return $this->belongsTo('ItemModel');
	}

}