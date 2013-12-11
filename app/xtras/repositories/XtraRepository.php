<?php namespace Xtras\Repositories;

use Xtra;
use XtraRepositoryInterface;

class XtraRepository implements XtraRepositoryInterface {

	public function find($value)
	{
		if (is_numeric($value))
			return Xtra::find($value);

		return Xtra::slug($value)->first();
	}

	public function getNewest($limit)
	{
		return Xtra::orderAsc('created_at')->take($limit)->get();
	}

	public function getRecentlyUpdated($limit)
	{
		return Xtra::where('updated_at', '>', 'created_at')
			->orderAsc('updated_at')->take($limit)->get();
	}

}