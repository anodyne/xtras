<?php namespace Xtras\Repositories\Eloquent;

use Input,
	ItemModel,
	TypeModel,
	UserModel,
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

	public function findByAuthor($author)
	{
		// Get the user
		$user = UserModel::where('slug', $author)->first();

		if ($user)
		{
			return $user->items;
		}

		return false;
	}

	public function findByAuthorAndSlug($author, $slug)
	{
		// Get all items for the author
		$items = $this->findByAuthor($author);

		if ($items)
		{
			return $items->filter(function($i) use ($slug)
			{
				return $i->slug === $slug;
			})->first();
		}

		return false;
	}

	public function findByName($name)
	{
		return ItemModel::where('name', $name)->get();
	}

	public function findBySlug($slug)
	{
		return ItemModel::where('slug', 'like', "%{$slug}%")->get();
	}

	public function findByType($type)
	{
		switch ($type)
		{
			case 'mods':
				$type = TypeModel::where('name', 'MOD')->first();
			break;

			case 'ranks':
				$type = TypeModel::where('name', 'Rank Set')->first();
			break;

			case 'skins':
				$type = TypeModel::where('name', 'Skin')->first();
			break;
		}

		return $type->items->sortBy(function($s)
		{
			return $s->name;
		});
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

	public function search($input)
	{
		return ItemModel::where('name', 'like', "%{$input}%")
			->orWhere('desc', 'like', "%{$input}%")
			->get();
	}

	public function searchAdvanced(array $input)
	{
		$search = ItemModel::query();

		if (array_key_exists('type', $input) and count($input['type']) > 0)
		{
			$search = $search->whereIn('type_id', $input['type']);
		}

		if (array_key_exists('product', $input) and count($input['product']) > 0)
		{
			$search = $search->whereIn('product_id', $input['product']);
		}

		if ( ! empty($input['search']))
		{
			$search = $search->where('name', 'like', "%{$input['search']}%")
				->orWhere('desc', 'like', "%{$input['search']}%");
		}

		return $search->get();
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