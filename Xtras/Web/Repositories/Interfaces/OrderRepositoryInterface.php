<?php namespace Xtras\Repositories\Interfaces;

use UserModel,
	ItemFileModel;

interface OrderRepositoryInterface {

	public function create(UserModel $user, ItemFileModel $file);

}