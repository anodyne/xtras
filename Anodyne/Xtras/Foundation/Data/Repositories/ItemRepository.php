<?php namespace Xtras\Foundation\Data\Repositories;

use Item,
	Type,
	User,
	Comment,
	ItemFile,
	ItemMessage;
use Rees\Sanitizer\Sanitizer;
use Illuminate\Support\Collection;

class ItemRepository implements \ItemRepositoryInterface {

	protected $users;

	public function __construct(\UserRepositoryInterface $users)
	{
		$this->users = $users;
	}

	public function addComment($itemId, array $data)
	{
		// Get the item
		$item = $this->find($itemId);

		if ($item)
		{
			$sanitizer = new Sanitizer;
			$sanitizer->sanitize([
				'user_id'	=> 'trim',
				'item_id'	=> 'trim',
				'content'	=> 'trim|strip_tags'
			], $data);

			// Create a comment record
			$comment = Comment::create($data);

			// Attach the comment to the item
			$item->comments()->save($comment);

			return $comment;
		}

		return false;
	}

	public function addMessage($itemId, array $data)
	{
		// Get the item
		$item = $this->find($itemId);

		if ($item)
		{
			// Setup the expiration
			if ( ! empty($data['expires']))
			{
				$expires = \Date::createFromFormat('m/d/Y', $data['expires']);

				$data['expires'] = $expires->endOfDay();
			}
			else
			{
				unset($data['expires']);
			}

			$sanitizer = new Sanitizer;
			$sanitizer->sanitize([
				'item_id'	=> 'trim',
				'content'	=> 'trim|strip_tags'
			], $data);

			// Create the message
			$message = ItemMessage::create($data);

			// Associate the message with the item
			$item->messages()->save($message);

			return $message;
		}

		return false;
	}

	public function all()
	{
		return Item::all();
	}

	public function create(array $data)
	{
		// Create the item
		$item = Item::create($data);

		// If there's metadata, update it
		if (array_key_exists('metadata', $data))
		{
			$this->updateMetaData($item->id, $data['metadata']);
		}

		// If there are file metadata, create that data
		if (array_key_exists('files', $data))
		{
			$this->updateFileData($item->id, $data['files']);
		}

		return $item;
	}

	public function delete($id)
	{
		// Get the item
		$item = $this->find($id);

		if ($item)
		{
			// Remove all the messages
			if ($item->messages->count() > 0)
			{
				foreach ($item->messages as $message)
				{
					$message->forceDelete();
				}
			}

			// Remove all the files
			if ($item->files->count() > 0)
			{
				// Get an instance of the filesystem
				$fs = \App::make('xtras.filesystem');

				foreach ($item->files as $file)
				{
					// Delete the file
					if ($fs->has($file->filename))
					{
						$fs->delete($file->filename);
					}

					// Remove the database record
					$file->forceDelete();
				}
			}

			// Remove all the ratings
			if ($item->ratings->count() > 0)
			{
				foreach ($item->ratings as $rating)
				{
					$rating->delete();
				}
			}

			// Remove all the comments
			if ($item->comments->count() > 0)
			{
				foreach ($item->comments as $comment)
				{
					$comment->delete();
				}
			}

			// Remove all the metadata
			if ($item->metadata->count() > 0)
			{
				$item->metadata->forceDelete();
			}

			// Remove the item
			$item->delete();

			return $item;
		}

		return false;
	}

	public function deleteFile($id)
	{
		// Get the file
		$file = $this->findFile($id);

		if ($file)
		{
			$file->forceDelete();

			return $file;
		}

		return false;
	}

	public function deleteImage($itemId, $imageNumber)
	{
		// Get the item
		$item = $this->find($itemId);

		if ($item)
		{
			// Get the metadata
			$metadata = $item->metadata;

			// Update the values
			$metadata->{"image{$imageNumber}"} = null;
			$metadata->{"thumbnail{$imageNumber}"} = null;
			$metadata->save();
		}

		return false;
	}

	public function deleteMessage($id)
	{
		// Get the message
		$message = $this->findMessage($id);

		if ($message)
		{
			$message->forceDelete();

			return $message;
		}

		return false;
	}

	public function find($id)
	{
		return Item::find($id);
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
		return Item::where('name', $name)->get();
	}

	public function findBySlug($slug)
	{
		return Item::where('slug', 'like', "%{$slug}%")->get();
	}

	public function findByType($type, $paginate = false, $splitByProduct = false)
	{
		switch ($type)
		{
			case 'mods':
				$type = Type::with('items.user', 'items.metadata', 'items.product', 'items.type')
					->where('name', 'MOD')->first();
			break;

			case 'ranks':
				$type = Type::with('items.user', 'items.metadata', 'items.product', 'items.type')
					->where('name', 'Rank Set')->first();
			break;

			case 'skins':
				$type = Type::with('items.user', 'items.metadata', 'items.product', 'items.type')
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

	public function findComment($id)
	{
		return Comment::with('item', 'item.user', 'item.type', 'user')->find($id);
	}

	public function findFile($id)
	{
		return ItemFile::with('item')->where('id', $id)->first();
	}

	public function findMessage($id)
	{
		return ItemMessage::with('item')->where('id', $id)->first();
	}

	public function getByPage($type, $page = 1, $limit = 15, $order = 'created_at', $direction = 'desc')
	{
		// Get the type
		$itemType = ($type) ? Type::active()->name($type)->first() : false;

		// Build the results
		$results = new \stdClass;
		$results->page = $page;
		$results->limit = $limit;
		$results->totalItems = ($type) 
			? Item::active()->itemType($itemType->id)->count() 
			: Item::active()->count();
		$results->items = [];

		if ($type)
		{
			$items = Item::with('metadata', 'type', 'user', 'product')
				->active()
				->itemType($itemType->id)
				->orderBy($order, $direction)
				->skip($limit * ($page - 1))->take($limit)->get();
		}
		else
		{
			$items = Item::with('metadata', 'type', 'user', 'product')
				->active()
				->orderBy($order, $direction)
				->skip($limit * ($page - 1))->take($limit)->get();
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

	public function getMessage($messageId)
	{
		return ItemMessage::with('item')->active()->find($messageId);
	}

	public function getProducts()
	{
		return \Product::active()->lists('name', 'id');
	}

	public function getRecentlyAdded($number)
	{
		return Item::with('product', 'type', 'user', 'metadata')
			->active()
			->orderBy('created_at', 'desc')
			->take($number)
			->get();
	}

	public function getRecentlyUpdated($number)
	{
		return Item::with('product', 'type', 'user', 'metadata')
			->active()
			->orderBy('updated_at', 'desc')
			->take($number)
			->get();
	}

	public function getTypes()
	{
		return Type::active()->lists('name', 'id');
	}

	public function getTypesByPermissions(User $user)
	{
		// Get all the types
		$types = Type::active()->get();

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

	public function rate(User $user, $itemId, $input)
	{
		// Get the item
		$item = $this->find($itemId);

		// If we have an item and the author isn't the one rating it...
		if ($item and $item->user->id != $user->id)
		{
			// Create a new rating
			$rating = \ItemRating::firstOrCreate([
				'item_id'	=> $item->id,
				'user_id'	=> $user->id
			]);
			$rating->fill(['rating' => (int) $input])->save();

			// Update the overall rating
			$item->updateRating();

			return $rating;
		}

		return false;
	}

	public function search($input)
	{
		return Item::with('product', 'type', 'user')
			->where(function($query) use ($input)
			{
				$query->where('name', 'like', "%{$input}%")
					->orWhere('desc', 'like', "%{$input}%");
			})->active()->paginate(25);
	}

	public function searchAdvanced(array $input)
	{
		$search = Item::query()->with('product', 'type', 'user');

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

		return $search->active()->paginate(25);
	}

	public function update($itemId, array $data)
	{
		// Get the item
		$item = $this->find($itemId);

		if ($item)
		{
			$item->fill($data)->save();

			// If there's metadata, update it
			if (array_key_exists('metadata', $data))
			{
				$this->updateMetaData($item->id, $data['metadata']);
			}

			// If there are file metadata, create that data
			if (array_key_exists('files', $data))
			{
				$this->updateFileData($item->id, $data['files']);
			}

			return $item;
		}

		return false;
	}

	public function updateFileData($itemId, array $data)
	{
		// Get the item
		$item = $this->find($itemId);

		if ($item)
		{
			$file = ItemFile::create($data);

			$item->files()->save($file);

			return $file;
		}

		return false;
	}

	public function updateMessage($messageId, array $data)
	{
		// Get the message
		$message = $this->findMessage($messageId);

		if ($message)
		{
			$message->fill($data)->save();

			return $message;
		}

		return false;
	}

	public function updateMetaData($itemId, array $data)
	{
		// Get the item
		$item = $this->find($itemId);

		if ($item)
		{
			if ($item->metadata)
			{
				$item->metadata->update($data);
			}
			else
			{
				$item->metadata()->save(\ItemMetadata::create($data));
			}
		}

		return false;
	}

}