<?php namespace Xtras\Repositories\Eloquent;

use UserModel,
	UtilityTrait,
	UserRepositoryContract;

class UserRepository implements UserRepositoryContract {

	use UtilityTrait;

	public function all()
	{
		return UserModel::all();
	}

	public function create(array $data, $flashMessage = true)
	{
		# code...
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

	public function update($id, array $data, $flashMessage = true)
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