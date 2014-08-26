<?php namespace Xtras\Foundation\Data\Repositories\Eloquent;

use UserModel,
	UtilityTrait,
	UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {

	use UtilityTrait;

	public function all()
	{
		return UserModel::all();
	}

	public function create(array $data = []){}

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

	public function update($id, array $data = [])
	{
		// Get the user
		$user = $this->find($id);

		if ($user)
		{
			$user->fill($data);
			$user->save();

			return $user;
		}

		return false;
	}

}