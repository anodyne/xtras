<?php namespace Xtras\Foundation\Data\Models\Eloquent;

use Model;

class ItemRatingModel extends Model {

	public $timestamps = false;

	protected $table = 'items_ratings';

	protected $fillable = ['user_id', 'item_id', 'rating'];

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function item()
	{
		return $this->belongsTo('ItemModel');
	}

	/*
	|---------------------------------------------------------------------------
	| Model Scopes
	|---------------------------------------------------------------------------
	*/

	public function scopeItem($query, $item)
	{
		$query->where('item_id', $item);
	}

	public function scopeUser($query, $user)
	{
		$query->where('user_id', $user);
	}

}