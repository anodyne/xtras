<?php namespace Xtras\Data\Repositories;

use User,
	Sanitize,
	Notification,
	UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {

	public function addNotification($userId, $itemId)
	{
		return Notification::firstOrCreate([
			'user_id' => (int) $userId,
			'item_id' => (int) $itemId,
		]);
	}

	public function all()
	{
		return User::get();
	}

	public function allForDropdown()
	{
		return User::orderBy('username', 'asc')->lists('username', 'id');
	}

	public function find($userId)
	{
		return User::with('items', 'items.metadata', 'items.type', 'items.product', 'items.user')
			->find($userId);
	}

	public function findByUsername($username)
	{
		return User::with('items', 'items.metadata', 'items.type', 'items.product', 'items.user')
			->where('username', $username)->first();
	}

	public function findItemsByName(User $user, $value)
	{
		return $user->items->filter(function($i) use ($value)
		{
			return $i->name == $value;
		});
	}

	public function findItemsBySlug(User $user, $value)
	{
		return $user->items->filter(function($i) use ($value)
		{
			return $i->slug == $value;
		});
	}

	public function findItemsByType(User $user, $value, $splitByProduct = false)
	{
		// Eager loading
		$user = $user->load('items', 'items.type', 'items.product', 'items.user');

		// Get just the items we want and sort them
		$filteredItems = $user->items->filter(function($i) use ($value)
		{
			return $i->type->name == $value;
		})->sortBy('name');

		if ($splitByProduct)
		{
			// An array of all the data
			$finalArray = [];

			$filteredItems->each(function($s) use (&$finalArray)
			{
				$finalArray[$s->product->name][] = $s;
			});

			ksort($finalArray);

			return $finalArray;
		}

		return $filteredItems;
	}

	public function getItemsByType(User $user)
	{
		// Make sure we're eager loaded what we need
		$user = $user->load('items', 'items.type', 'items.product', 'items.user');

		$itemsArr = [];

		foreach ($user->items->sortBy('name') as $item)
		{
			$itemsArr[$item->type->name][$item->product->name][] = $item;

			ksort($itemsArr[$item->type->name]);
		}

		return $itemsArr;
	}

	public function getNotifications(User $user)
	{
		// Eager loading
		$user = $user->load('notifications', 'notifications.item', 'notifications.item.user');

		return $user->notifications;
	}

	public function getOrders(User $user)
	{
		$user = $user->load('orders', 'orders.item', 'orders.item.user');

		return $user->orders->sortBy('created_at');
	}

	public function removeNotification($userId, $itemId)
	{
		// Get the notification
		$notification = Notification::where('user_id', $userId)
			->where('item_id', $itemId)
			->first();

		if ($notification)
		{
			$notification->delete();
		}

		return false;
	}

}