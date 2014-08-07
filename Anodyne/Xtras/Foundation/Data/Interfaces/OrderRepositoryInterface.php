<?php namespace Xtras\Foundation\Data\Interfaces;

use UserModel,
	ItemFileModel;

interface OrderRepositoryInterface {

	public function create(UserModel $user, ItemFileModel $file);

}