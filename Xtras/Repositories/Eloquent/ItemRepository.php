<?php namespace Xtras\Repositories\Eloquent;

use ItemModel,
	ItemRepositoryContract;

class ItemRepository implements ItemRepositoryContract {

	public function all()
	{
		return ItemModel::all();
	}

	public function create(array $data, $flashMessage = true)
	{
		# code...
	}

	public function delete($id, $flashMessage = true)
	{
		# code...
	}

	public function find($id)
	{
		return ItemModel::find($id);
	}

	public function findBySlug($slug)
	{
		return ItemModel::where('slug', $slug)->first();
	}

	public function getRecentlyAdded($number)
	{
		return ItemModel::orderDesc('created_at')->take($number)->get();
	}

	public function getRecentlyUpdated($number)
	{
		return ItemModel::orderDesc('updated_at')->take($number)->get();
	}

	public function update($id, array $data, $flashMessage = true)
	{
		# code...
	}

}