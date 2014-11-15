<?php namespace Xtras\Data\Repositories;

use User,
	Sanitize,
	Notification,
	UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {

	/**
	 * Add a notification for a user for an item.
	 *
	 * @param	int		$userId
	 * @param	int		$itemId
	 * @return	Notification
	 */
	public function addNotification($userId, $itemId)
	{
		return Notification::firstOrCreate([
			'user_id' => (int) $userId,
			'item_id' => (int) $itemId,
		]);
	}

	/**
	 * Get all users.
	 *
	 * @return	Collection
	 */
	public function all()
	{
		return User::get();
	}

	/**
	 * Find a user by their ID.
	 *
	 * @param	int		$userId
	 * @return	User
	 */
	public function find($userId)
	{
		return User::with('items', 'items.metadata', 'items.type', 'items.product', 'items.user')
			->find($userId);
	}

	/**
	 * Find a user by their username.
	 *
	 * @param	string	$username
	 * @return	User
	 */
	public function findByUsername($username)
	{
		return User::with('items', 'items.metadata', 'items.type', 'items.product', 'items.user')
			->where('username', $username)->first();
	}

	/**
	 * Find a user's items by an item name.
	 *
	 * @param	User	$user
	 * @param	string	$value
	 * @return	Collection
	 */
	public function findItemsByName(User $user, $value)
	{
		return $user->items->filter(function($i) use ($value)
		{
			return $i->name == $value;
		});
	}

	/**
	 * Find a user's items by an item slug.
	 *
	 * @param	User	$user
	 * @param	string	$value
	 * @return	Collection
	 */
	public function findItemsBySlug(User $user, $value)
	{
		return $user->items->filter(function($i) use ($value)
		{
			return $i->slug == $value;
		});
	}

	/**
	 * Get a user's items broken up by item type.
	 *
	 * @param	User	$user
	 * @return	array
	 */
	public function getItemsByType(User $user)
	{
		// Make sure we're eager loaded what we need
		$user = $user->load('items', 'items.type', 'items.product', 'items.user');

		$itemsArr = [];

		foreach ($user->items->sortBy('name') as $item)
		{
			$itemsArr[$item->type->name][$item->product->name][] = $item;

			krsort($itemsArr[$item->type->name]);
		}

		return $itemsArr;
	}

	/**
	 * Get all notifications for a user.
	 *
	 * @param	User	$user
	 * @return	Collection
	 */
	public function getNotifications(User $user)
	{
		// Eager load some relationships
		$user = $user->load('notifications', 'notifications.item', 'notifications.item.user');

		return $user->notifications;
	}

	/**
	 * Get all orders for a user.
	 *
	 * @param	User	$user
	 * @return	Collection
	 */
	public function getOrders(User $user)
	{
		// Eager load some relationships
		$user = $user->load('orders', 'orders.item', 'orders.item.user', 'orders.file');

		return $user->orders->sortByDesc('created_at');
	}

	/**
	 * List all users in an array.
	 *
	 * @return	array
	 */
	public function listAll()
	{
		return User::orderBy('username', 'asc')->lists('username', 'id');
	}

	/**
	 * Remove a notification for a user for an item.
	 *
	 * @param	int		$userId
	 * @param	int		$itemId
	 * @return	bool
	 */
	public function removeNotification($userId, $itemId)
	{
		// Get the notification
		$notification = Notification::where('user_id', $userId)
			->where('item_id', $itemId)
			->first();

		if ($notification)
		{
			// Remove the notification
			$notification->delete();

			return true;
		}

		return false;
	}

	/**
	 * Generate a report about how much space users are using.
	 *
	 * @return	array
	 */
	public function reportSizes()
	{
		// Get all users
		$users = $this->all();

		// Eager load some relationships
		$users = $users->load('items', 'items.files');

		$report = [];

		foreach ($users as $user)
		{
			$report[$user->id]['user'] = $user;
			$report[$user->id]['prettySize'] = "N/A";

			foreach ($user->items as $item)
			{
				foreach ($item->files as $file)
				{
					if (array_key_exists('size', $report[$user->id]))
					{
						$report[$user->id]['size'] += (int) $file->size;
					}
					else
					{
						$report[$user->id]['size'] = (int) $file->size;
					}

					$report[$user->id]['prettySize'] = convertFileSize($report[$user->id]['size']);
				}
			}
		}

		usort($report, function($a, $b)
		{
			return $b['prettySize'] - $a['prettySize'];
		});

		return $report;
	}

}