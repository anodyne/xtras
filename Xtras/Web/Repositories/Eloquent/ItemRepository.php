<?php namespace Xtras\Repositories\Eloquent;

use ItemModel,
	TypeModel,
	ProductModel,
	ItemRepositoryContract;

class ItemRepository implements ItemRepositoryContract {

	public function all()
	{
		return ItemModel::all();
	}

	public function create(array $data, $flashMessage = true)
	{
		$item = ItemModel::create($data);

		if ($flashMessage)
		{
			//
		}

		return $item;
	}

	public function delete($id, $flashMessage = true)
	{
		# code...
	}

	public function find($id)
	{
		return ItemModel::find($id);
	}

	public function findByName($name)
	{
		return ItemModel::where('name', $name)->get();
	}

	public function getItemTypes()
	{
		return TypeModel::lists('name', 'id');
	}

	public function getProducts()
	{
		return ProductModel::lists('name', 'id');
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