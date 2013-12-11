<?php namespace Xtras\Repositories;

use Item;
use ItemRepositoryInterface;

class ItemRepository implements ItemRepositoryInterface {

	public function find($value)
	{
		if (is_numeric($value))
			return Item::find($value);

		return Item::slug($value)->first();
	}

	public function getNewest($limit)
	{
		return Item::orderAsc('created_at')->take($limit)->get();
	}

	public function getRecentlyUpdated($limit)
	{
		return Item::where('updated_at', '>', 'created_at')
			->orderAsc('updated_at')->take($limit)->get();
	}

}