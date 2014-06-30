<?php namespace Xtras\Repositories\Eloquent;

use UserModel,
	UtilityTrait,
	UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {

	use UtilityTrait;

	public function all()
	{
		return UserModel::all();
	}

	public function create(array $data = [], $flashMessage = true)
	{
		// Create the user
		$user = UserModel::create($data);

		// Set the role
		$user->roles()->attach(2);

		return $user;
	}

	public function delete($id, $flashMessage = true)
	{
		# code...
	}

	public function find($id)
	{
		return UserModel::find($id);
	}

	public function findBySlug($slug)
	{
		return UserModel::where('slug', $slug)->first();
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

	public function update($id, array $data = [], $flashMessage = true)
	{
		// Get the user
		$user = $this->find($id);

		if ($user)
		{
			$user->fill($data);
			$updated = $user->save();

			if ($flashMessage)
			{
				// Set the flash info
				$status = ($updated) ? 'success' : 'danger';
				$message = ($updated) 
					? "User account has been successfully updated!"
					: "User account update failed. Please try again.";

				// Flash the session
				$this->setFlashMessage($status, $message);
			}

			return $user;
		}

		return false;
	}

}