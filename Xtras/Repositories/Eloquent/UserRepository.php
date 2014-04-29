<?php namespace Xtras\Repositories\Eloquent;

use UserModel,
	UserRepositoryContract;

class UserRepository implements UserRepositoryContract {

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
		# code...
	}

}