<?php namespace Xtras\Repositories\Eloquent;

use ItemModel,
	TypeModel,
	ProductModel,
	ItemMetaModel,
	ItemRepositoryContract;

class ItemRepository implements ItemRepositoryContract {

	public function all()
	{
		return ItemModel::all();
	}

	public function create(array $data, $flashMessage = true)
	{
		$item = ItemModel::create($data);

		if (array_key_exists('meta', $data))
		{
			$this->updateMetaData($item->id, $data['meta']);
		}

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

	public function updateMetaData($id, array $data)
	{
		// Get the item
		$item = $this->find($id);

		if ($item->meta)
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