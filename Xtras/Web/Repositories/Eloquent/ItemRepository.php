<?php namespace Xtras\Repositories\Eloquent;

use Input,
	ItemModel,
	TypeModel,
	ProductModel,
	ItemMetaModel,
	ItemRepositoryInterface;

class ItemRepository implements ItemRepositoryInterface {

	public function all()
	{
		return ItemModel::all();
	}

	public function create(array $data = [], $flashMessage = true)
	{
		$item = new ItemModel;
		$item->save();

		if (Input::has('meta'))
		{
			$this->updateMetaData($item->id, Input::get('meta'));
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
		return ItemModel::orderBy('created_at', 'desc')->take($number)->get();
	}

	public function getRecentlyUpdated($number)
	{
		return ItemModel::orderBy('updated_at', 'desc')->take($number)->get();
	}

	public function update($id, array $data = [], $flashMessage = true)
	{
		# code...
	}

	public function updateMetaData($id, array $data)
	{
		// Get the item
		$item = $this->find($id);

		if ($item->meta->count() > 0)
		{
			// Get the meta data
			$meta = $item->meta;
			$meta->update($data);
		}
		else
		{
			// Create a new instance
			$meta = new ItemMetaModel;
			$meta->fill($data);
			$meta->save();

			$item->meta()->save($meta);
		}
	}

}