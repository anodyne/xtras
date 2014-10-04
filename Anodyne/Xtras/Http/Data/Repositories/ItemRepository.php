<?php namespace Xtras\Data\Repositories;

use App,
	Auth,
	Date,
	Item,
	Type,
	User,
	Comment,
	ItemFile,
	Sanitize,
	Paginator,
	ItemRating,
	ItemMessage,
	ItemMetadata,
	ItemRepositoryInterface,
	UserRepositoryInterface;
use stdClass;
use Illuminate\Support\Collection;

class ItemRepository implements ItemRepositoryInterface {

	protected $users;

	public function __construct(UserRepositoryInterface $users)
	{
		$this->users = $users;
	}

	/**
	 * Add a comment to an item.
	 *
	 * @param	int		$itemId
	 * @param	array	$data
	 * @return	Comment
	 */
	public function addComment($itemId, array $data)
	{
		// Get the item
		$item = $this->find($itemId);

		if ($item)
		{
			// Sanitize the data
			$data = Sanitize::clean($data, Comment::$sanitizeRules);

			// Create a comment record
			$comment = Comment::create($data);

			// Attach the comment to the item
			$item->comments()->save($comment);

			return $comment;
		}

		return false;
	}

	/**
	 * Add a message to an item.
	 *
	 * @param	int		$itemId
	 * @param	array	$data
	 * @return	ItemMessage
	 */
	public function addMessage($itemId, array $data)
	{
		// Get the item
		$item = $this->find($itemId);

		if ($item)
		{
			// Clear out the expiration field if there's nothing in it
			if (empty($data['expires']))
			{
				unset($data['expires']);
			}

			// Set the item ID
			$data['item_id'] = (int) $item->id;

			// Sanitize the data
			$data = Sanitize::clean($data, ItemMessage::$sanitizeRules);

			// Setup the expiration. This has to happen after the data is
			// sanitized otherwise we lose the Carbon object that we create
			if ( ! empty($data['expires']))
			{
				// Build a Carbon object from the expiration date string
				$expires = Date::createFromFormat('m/d/Y', $data['expires']);

				// All messages expire at the end of the day selected
				$data['expires'] = $expires->endOfDay();
			}

			// Create the message
			return ItemMessage::create($data);
		}

		return false;
	}

	/**
	 * Get all the items.
	 *
	 * @return	Collection
	 */
	public function all()
	{
		return Item::get();
	}

	/**
	 * Create a new item.
	 *
	 * @param	array	$data
	 * @return	Item
	 */
	public function create(array $data)
	{
		// We need to store metadata and file data before sanitizing otherwise
		// we lose that information during the sanitation process
		$metadata = (array_key_exists('metadata', $data)) ? $data['metadata'] : false;
		$filedata = (array_key_exists('files', $data)) ? $data['files'] : false;

		// Sanitize the data
		$data = Sanitize::clean($data, Item::$sanitizeRules);

		// Make sure only the right people can change the admin status
		if (array_key_exists('admin_status', $data) and ! Auth::user()->can('xtras.admin'))
		{
			unset($data['admin_status']);
		}

		// Create the item
		$item = Item::create($data);

		// If there's metadata, update it
		if ($metadata)
		{
			$this->updateMetadata($item->id, $metadata);
		}

		// If there are file data, update it
		if ($filedata)
		{
			$this->updateFileData($item->id, $filedata);
		}

		return $item;
	}

	/**
	 * Delete an item by its ID.
	 *
	 * @param	int		$id
	 * @return	Item/bool
	 */
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
				$fs = App::make('xtras.filesystem');

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

	/**
	 * Delete a file record by its ID.
	 *
	 * @param	int		$fileId
	 * @return	ItemFile/bool
	 */
	public function deleteFile($fileId)
	{
		// Get the file
		$file = $this->findFile($fileId);

		if ($file)
		{
			// Delete the file record for good
			$file->forceDelete();

			return $file;
		}

		return false;
	}

	/**
	 * Remove an image from the metadata.
	 *
	 * @param	int		$itemId
	 * @param	int		$imageNum	The number of the image to remove
	 * @return	bool
	 */
	public function deleteImage($itemId, $imageNum)
	{
		// Get the item
		$item = $this->find($itemId);

		if ($item)
		{
			// Get the metadata
			$metadata = $item->metadata;

			// Update the values
			$metadata->{"image{$imageNum}"} = null;
			$metadata->{"thumbnail{$imageNum}"} = null;
			$metadata->save();

			return true;
		}

		return false;
	}

	/**
	 * Delete an item message by its ID.
	 *
	 * @param	int		$msgId
	 * @return	ItemMessage/bool
	 */
	public function deleteMessage($msgId)
	{
		// Get the message
		$message = $this->findMessage($msgId);

		if ($message)
		{
			// Delete the message for good
			$message->forceDelete();

			return $message;
		}

		return false;
	}

	/**
	 * Find an item by its ID.
	 *
	 * @param	int		$id
	 * @return	Item
	 */
	public function find($id)
	{
		return Item::find($id);
	}

	/**
	 * Find all items by the author's username.
	 *
	 * @param	string	$author
	 * @return	Collection/bool
	 */
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

	/**
	 * Find an item by the author's username and the item's slug.
	 *
	 * @param	string	$author
	 * @param	string	$slug
	 * @return	Item/bool
	 */
	public function findByAuthorAndSlug($author, $slug)
	{
		// Get all items for the author
		$items = $this->findByAuthor($author);

		if ($items)
		{
			// Eager load some relationships
			$items = $items->load('files', 'comments', 'messages', 'orders');

			return $items->filter(function($i) use ($slug)
			{
				return $i->slug === $slug;
			})->first();
		}

		return false;
	}

	/**
	 * Find items by a name.
	 *
	 * @param	string	$name
	 * @return	Item
	 */
	public function findByName($name)
	{
		return Item::where('name', $name)->get();
	}

	/**
	 * Find items by a slug.
	 *
	 * @param	string	$slug
	 * @return	Item
	 */
	public function findBySlug($slug)
	{
		return Item::where('slug', 'like', "%{$slug}%")->get();
	}

	/**
	 * Find items by type.
	 *
	 * @param	string	$type
	 * @param	bool	$paginate	Should the results be paginated?
	 * @param	bool	$split		Should the results be split by product?
	 * @return	array/Paginator/Collection
	 */
	public function findByType($type, $paginate = false, $split = false)
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

		if ($split)
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
			return Paginator::make($sortedItems->toArray(), $sortedItems->count(), 25);
		}

		return $sortedItems;
	}

	/**
	 * Find a comment by its ID.
	 *
	 * @param	int		$commentId
	 * @return	Comment
	 */
	public function findComment($commentId)
	{
		return Comment::with('item', 'item.user', 'item.type', 'user')->find($commentId);
	}

	/**
	 * Find a file by its ID.
	 *
	 * @param	int		$fileId
	 * @return	ItemFile
	 */
	public function findFile($fileId)
	{
		return ItemFile::with('item')->find($fileId);
	}

	/**
	 * Find a message by its ID.
	 *
	 * @param	int		$msgId
	 * @return	ItemMessage
	 */
	public function findMessage($msgId)
	{
		return ItemMessage::with('item')->find($msgId);
	}

	/**
	 * Get items by type and paginate them manually.
	 *
	 * @param	string	$type
	 * @param	int		$page		The current page we're on
	 * @param	int		$limit		How many items per page?
	 * @param	string	$order		The field to use for ordering
	 * @param	string	$direction	The direction to sort the $order field
	 * @return	object
	 */
	public function getByPage($type, $page = 1, $limit = 15, $order = 'created_at', $direction = 'desc')
	{
		// Get the type
		$itemType = ($type) ? Type::active()->name($type)->first() : false;

		// Build the results
		$results = new stdClass;
		$results->page = $page;
		$results->limit = $limit;
		$results->totalItems = ($type) 
			? Item::active()->itemType($itemType->id)->count() 
			: Item::active()->count();
		$results->items = [];

		// Get the items based on the type (or lack thereof)
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

		// Dump all the items into the result set
		$results->items = $items->all();

		return $results;
	}

	/**
	 * Get all comments for an item.
	 *
	 * @param	int		$itemId
	 * @return	Collection
	 */
	public function getComments($itemId)
	{
		// Get the item
		$item = $this->find($itemId);

		if ($item)
		{
			// Pull back the comments and sort them in descending order
			return $item->comments->sortByDesc('created_at');
		}

		return new Collection;
	}

	/**
	 * Get a message by its ID.
	 *
	 * @param	int		$msgId
	 * @return	ItemMessage
	 */
	public function getMessage($msgId)
	{
		return ItemMessage::with('item')->find($msgId);
	}

	/**
	 * Get the most recently added items.
	 *
	 * @param	int		$number	How many items to pull
	 * @return	Collection
	 */
	public function getRecentlyAdded($number)
	{
		return Item::with('product', 'type', 'user', 'metadata')
			->active()
			->orderBy('created_at', 'desc')
			->take($number)
			->get();
	}

	/**
	 * Get the most recently updated items.
	 *
	 * @param	int		$number	How many items to pull
	 * @return	Collection
	 */
	public function getRecentlyUpdated($number)
	{
		return Item::with('product', 'type', 'user', 'metadata')
			->active()
			->orderBy('updated_at', 'desc')
			->take($number)
			->get();
	}

	/**
	 * Rate an item.
	 *
	 * @param	User	$user
	 * @param	int		$itemId
	 * @param	array	$rating
	 * @return	ItemRating/bool
	 */
	public function rate(User $user, $itemId, $rating)
	{
		// Get the item
		$item = $this->find($itemId);

		// If we have an item and the author isn't the one rating it...
		if ($item and $item->user->id != $user->id)
		{
			// Create a new rating
			$rating = ItemRating::firstOrCreate([
				'item_id'	=> (int) $item->id,
				'user_id'	=> (int) $user->id
			]);
			$rating->fill(['rating' => (int) $rating])->save();

			// Update the overall rating
			$item->updateRating();

			return $rating;
		}

		return false;
	}

	/**
	 * Generate the report about item sizes.
	 *
	 * @return	object
	 */
	public function reportSizes()
	{
		// Get all the items
		$items = $this->all();

		// Eager load some relationships
		$items = $items->load('files', 'product', 'type', 'user');

		$report = [];

		foreach ($items as $item)
		{
			$report[$item->id]['item'] = $item;
			$report[$item->id]['prettySize'] = "N/A";

			foreach ($item->files as $file)
			{
				if (array_key_exists('size', $report[$item->id]))
				{
					$report[$item->id]['size'] += (int) $file->size;
				}
				else
				{
					$report[$item->id]['size'] = (int) $file->size;
				}

				$report[$item->id]['prettySize'] = convertFileSize($report[$item->id]['size']);
			}
		}

		usort($report, function($a, $b)
		{
			return $b['prettySize'] - $a['prettySize'];
		});

		return $report;
	}

	/**
	 * Search for an item by its name and/or description and paginate the
	 * results.
	 *
	 * @param	string	$input
	 * @return	Paginator
	 */
	public function search($input)
	{
		return Item::with('product', 'type', 'user')
			->where(function($query) use ($input)
			{
				$query->where('name', 'like', "%{$input}%")
					->orWhere('desc', 'like', "%{$input}%");
			})->active()->paginate(25);
	}

	/**
	 * Do an advanced search for items based on multiple criteria and paginate
	 * the results.
	 *
	 * @param	array	$input
	 * @return	Paginator
	 */
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

	/**
	 * Update an item based on its ID.
	 *
	 * @param	int		$itemId
	 * @param	array	$data
	 * @return	Item/bool
	 */
	public function update($itemId, array $data)
	{
		// Get the item
		$item = $this->find($itemId);

		if ($item)
		{
			// We need to store metadata and file data before sanitizing otherwise
			// we lose that information during the sanitation process
			$metadata = (array_key_exists('metadata', $data)) ? $data['metadata'] : false;
			$filedata = (array_key_exists('files', $data)) ? $data['files'] : false;

			// Sanitize the data
			$data = Sanitize::clean($data, Item::$sanitizeRules);

			// Make sure only the right people can change the admin status
			if (array_key_exists('admin_status', $data) and ! Auth::user()->can('xtras.admin'))
			{
				unset($data['admin_status']);
			}

			// Fill and save the item
			$item->fill($data)->save();

			// If there's metadata, update it
			if ($metadata)
			{
				$this->updateMetadata($item->id, $metadata);
			}

			// If there are file data, update it
			if ($filedata)
			{
				$this->updateFileData($item->id, $filedata);
			}

			return $item;
		}

		return false;
	}

	/**
	 * Update the file data for an item.
	 *
	 * @param	int		$itemId
	 * @param	array	$data
	 * @return	ItemFile/bool
	 */
	public function updateFileData($itemId, array $data)
	{
		// Get the item
		$item = $this->find($itemId);

		if ($item)
		{
			// Sanitize the data
			$data = Sanitize::clean($data, ItemFile::$sanitizeRules);

			// Create a new file record (we can only have one file per version)
			$file = ItemFile::create($data);

			// Attach the file record to the item
			$item->files()->save($file);

			return $file;
		}

		return false;
	}

	/**
	 * Update a message.
	 *
	 * @param	int		$msgId
	 * @param	array	$data
	 * @return	ItemMessage/bool
	 */
	public function updateMessage($msgId, array $data)
	{
		// Get the message
		$message = $this->findMessage($msgId);

		if ($message)
		{
			// Clear out the expiration field if there's nothing in it
			if (empty($data['expires']))
			{
				unset($data['expires']);
			}

			// Sanitize the data
			$data = Sanitize::clean($data, ItemMessage::$sanitizeRules);


			// Setup the expiration. This has to happen after the data is
			// sanitized otherwise we lose the Carbon object that we create
			if ( ! empty($data['expires']))
			{
				// Build a Carbon object from the expiration date string
				$expires = Date::createFromFormat('m/d/Y', $data['expires']);

				// All messages expire at the end of the day selected
				$data['expires'] = $expires->endOfDay();
			}
			
			// Fill and save the message
			$message->fill($data)->save();

			return $message;
		}

		return false;
	}

	/**
	 * Update the metadata for an item.
	 *
	 * @param	int		$itemId
	 * @param	array	$data
	 * @return	ItemMetadata/bool
	 */
	public function updateMetadata($itemId, array $data)
	{
		// Get the item
		$item = $this->find($itemId);

		if ($item)
		{
			// Sanitize the data
			$data = Sanitize::clean($data, ItemMetadata::$sanitizeRules);

			if ($item->metadata)
			{
				// There's already a record, so just update it
				$item->metadata->fill($data)->save();

				return $item->metadata;
			}
			else
			{
				// Create a new metadata record
				$metadata = ItemMetadata::create($data);

				// Attach the metadata record to the item
				$item->metadata()->save($metadata);

				return $metadata;
			}
		}

		return false;
	}

}