<?php namespace Xtras\Repositories;

use User;
use UserNameTakenException;
use UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {

	public function all()
	{
		return User::all();
	}
	
	/**
	 * Create a new user.
	 *
	 * @param	array	Data to create the user with
	 * @return	User
	 */
	public function create(array $data)
	{
		// Find any users with the same name
		$user = User::where('name', $data['name'])->count();

		// If we found any users, throw an exception
		if ($userCount > 0)
			throw new UserNameTakenException;

		return User::create($data);
	}

	/**
	 * Get a specific user by ID or slug.
	 *
	 * @param	mixed	Either a user ID or user slug
	 * @return	User
	 */
	public function find($value)
	{
		if (is_numeric($value))
			return User::find($value);

		return User::slug($value)->first();
	}

	public function update($id, array $data)
	{
		// Get the user
		$user = $this->find($id);

		if ($user)
			return $user->update($data);

		return false;
	}

}