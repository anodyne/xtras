<?php namespace Xtras\Models;

use Model;

class Xtra extends Model {

	protected $table = 'xtras';

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