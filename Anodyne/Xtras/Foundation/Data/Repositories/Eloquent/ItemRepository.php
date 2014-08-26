<?php namespace Xtras\Foundation\Data\Repositories\Eloquent;

use Auth,
	Input,
	ItemModel,
	TypeModel,
	UserModel,
	CommentModel,
	ProductModel,
	ItemFileModel,
	ItemMetaModel,
	CommentTransformer,
	ItemRepositoryInterface,
	UserRepositoryInterface;
use Illuminate\Support\Collection;

class ItemRepository implements ItemRepositoryInterface {

	protected $users;

	public function __construct(UserRepositoryInterface $users)
	{
		$this->users = $users;
	}

	public function addComment($id, array $data)
	{
		// Get the item
		$item = $this->find($id);

		if ($item)
		{
			// Create a comment record
			$comment = new CommentModel;
			$comment->fill($data);
			$comment->save();

			// Attach the comment to the item
			$item->comments()->save($comment);

			return $comment;
		}

		return false;
	}

	public function all()
	{
		return ItemModel::all();
	}

	public function create(array $data = [])
	{
		$item = ItemModel::create($data);

		if (Input::has('meta'))
		{
			$this->updateMetaData($item->id, Input::get('meta'));
		}

		if (Input::has('files'))
		{
			$this->updateFileData($item->id, Input::get('files'));
		}

		return $item;
	}

	public function delete($id)
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
		$user = $this->users->findByUsername($author);

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
			// Eager loading
			$items = $items->load('files', 'comments', 'messages', 'orders');

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

	public function findByType($type, $paginate = false, $splitByProduct = false)
	{
		switch ($type)
		{
			case 'mods':
				$type = TypeModel::with('items.user', 'items.meta', 'items.product', 'items.type')
					->where('name', 'MOD')->first();
			break;

			case 'ranks':
				$type = TypeModel::with('items.user', 'items.meta', 'items.product', 'items.type')
					->where('name', 'Rank Set')->first();
			break;

			case 'skins':
				$type = TypeModel::with('items.user', 'items.meta', 'items.product', 'items.type')
					->where('name', 'Skin')->first();
			break;
		}

		$sortedItems = $type->items->sortBy(function($s)
		{
			return $s->name;
		});

		if ($splitByProduct)
		{
			// An array of all the data
			$finalArray = [];

			$sortedItems->each(function($s) use (&$finalArray)
			{
				$finalArray[$s->product->name][] = $s;
			});

			return $finalArray;
		}

		if ($paginate)
		{
			return \Paginator::make($sortedItems->toArray(), $sortedItems->count(), 25);
		}

		return $sortedItems;
	}

	public function getByPage($type, $page = 1, $limit = 15, $order = 'created_at', $direction = 'desc')
	{
		// Get the type
		$itemType = ($type) ? TypeModel::name($type)->first() : false;

		// Build the results
		$results = new \stdClass;
		$results->page = $page;
		$results->limit = $limit;
		$results->totalItems = ($type) ? ItemModel::itemType($itemType->id)->count() : ItemModel::count();
		$results->items = [];

		if ($type)
		{
			$items = ItemModel::with('meta', 'type', 'user', 'product')
				->itemType($itemType->id)
				->orderBy($order, $direction)
				->skip($limit * ($page - 1))->take($limit)->get();
		}
		else
		{
			$items = ItemModel::with('meta', 'type', 'user', 'product')
				->orderBy($order, $direction)->skip($limit * ($page - 1))->take($limit)->get();
		}

		$results->items = $items->all();

		return $results;
	}

	public function getComments($id)
	{
		// Get the item
		$item = $this->find($id);

		if ($item)
		{
			// Pull back the comments and sort them in descending order
			return $item->comments->sortByDesc('created_at');
		}

		return new Collection;
	}

	public function getFile($id)
	{
		return ItemFileModel::find($id);
	}

	public function getProducts()
	{
		return ProductModel::active()->lists('name', 'id');
	}

	public function getRecentlyAdded($number)
	{
		return ItemModel::with('product', 'type', 'user', 'meta')
			->orderBy('created_at', 'desc')->take($number)->get();
	}

	public function getRecentlyUpdated($number)
	{
		return ItemModel::with('product', 'type', 'user', 'meta')
			->orderBy('updated_at', 'desc')->take($number)->get();
	}

	public function getTypes()
	{
		return TypeModel::active()->lists('name', 'id');
	}

	public function getTypesByPermissions(UserModel $user)
	{
		// Get all the types
		$types = TypeModel::active()->get();

		// Start an array of items
		$finalTypes = [];

		foreach ($types as $type)
		{
			switch ($type->name)
			{
				case 'Skin':
					if ($user->can('xtras.item.skins'))
					{
						$finalTypes[$type->id] = $type->name;
					}
				break;

				case 'MOD':
					if ($user->can('xtras.item.mods'))
					{
						$finalTypes[$type->id] = $type->name;
					}
				break;

				case 'Rank Set':
					if ($user->can('xtras.item.ranks'))
					{
						$finalTypes[$type->id] = $type->name;
					}
				break;
			}
		}

		return $finalTypes;
	}

	public function search($input)
	{
		return ItemModel::with('product', 'type', 'user')
			->where('name', 'like', "%{$input}%")
			->orWhere('desc', 'like', "%{$input}%")
			->paginate(25);
	}

	public function searchAdvanced(array $input)
	{
		$search = ItemModel::query()->with('product', 'type', 'user');

		if (array_key_exists('t', $input) and count($input['t']) > 0)
		{
			$search = $search->whereIn('type_id', $input['t']);
		}

		if (array_key_exists('p', $input) and count($input['p']) > 0)
		{
			$search = $search->whereIn('product_id', $input['p']);
		}

		if ( ! empty($input['q']))
		{
			$search = $search->where(function($query) use ($input)
			{
				$query->where('name', 'like', "%{$input['q']}%")
					->orWhere('desc', 'like', "%{$input['q']}%");
			});
		}

		return $search->paginate(25);
	}

	public function update($id, array $data = [])
	{
		# code...
	}

	public function updateFileData($id, array $data)
	{
		// Get the item
		$item = $this->find($id);

		// Create a new instance
		$file = new ItemFileModel;
		$file->fill($data);
		$file->save();

		$item->files()->save($file);
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