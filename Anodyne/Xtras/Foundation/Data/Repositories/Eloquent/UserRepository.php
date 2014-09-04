<?php namespace Xtras\Foundation\Data\Repositories\Eloquent;

use UserModel,
	NotificationModel,
	UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {

	public function addNotification($user, $item)
	{
		return NotificationModel::firstOrCreate([
			'user_id' => $user,
			'item_id' => $item,
		]);
	}

	public function all()
	{
		return UserModel::all();
	}

	public function create(array $data){}

	public function delete($id){}

	public function find($id)
	{
		return UserModel::with('items', 'items.meta', 'items.type', 'items.product', 'items.user')
			->find($id);
	}

	public function findByUsername($username)
	{
		return UserModel::with('items', 'items.meta', 'items.type', 'items.product', 'items.user')
			->where('username', $username)->first();
	}

	public function findItemsByName(UserModel $user, $value)
	{
		return $user->items->filter(function($i) use ($value)
		{
			return $i->name == $value;
		});
	}

	public function findItemsBySlug(UserModel $user, $value)
	{
		return $user->items->filter(function($i) use ($value)
		{
			return $i->slug == $value;
		});
	}

	public function findItemsByType(UserModel $user, $value, $splitByProduct = false)
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

	public function getItemsByType(UserModel $user)
	{
		$itemsArr = [];

		// Make sure we're eager loaded what we need
		$user = $user->load('items', 'items.type', 'items.product', 'items.user');

		foreach ($user->items->sortBy('name') as $item)
		{
			$itemsArr[$item->type->name][$item->product->name][] = $item;

			ksort($itemsArr[$item->type->name]);
		}

		return $itemsArr;
	}

	public function getNotifications(UserModel $user)
	{
		// Eager loading
		$user = $user->load('notifications', 'notifications.item', 'notifications.item.user');

		return $user->notifications;
	}

	public function removeNotification($user, $item)
	{
		// Get the notification
		$notification = NotificationModel::where('user_id', $user)
			->where('item_id', $item)
			->first();

		if ($notification)
		{
			$notification->delete();
		}

		return false;
	}

	public function update($id, array $data){}

}