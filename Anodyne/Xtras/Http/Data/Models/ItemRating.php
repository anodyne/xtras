<?php namespace Xtras\Data\Models;

class ItemRating extends \Model {

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
		return $this->belongsTo('Item');
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