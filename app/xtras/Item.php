<?php namespace Xtras;

use Model;

class Item extends Model {

	protected $table = 'items';

	protected $fillable = array('user_id', 'name', 'desc', 'slug', 'support', 'preview_image');

	/*
	|--------------------------------------------------------------------------
	| Model Scopes
	|--------------------------------------------------------------------------
	*/

	public function scopeSlug($query, $slug)
	{
		$query->where('slug', $slug);
	}
	
}