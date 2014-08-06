<?php namespace Xtras\Repositories\Interfaces;

use UserModel;

interface UserRepositoryInterface extends BaseRepositoryInterface {

	public function findBySlug($slug);
	public function findItemsByName(UserModel $user, $value);
	public function findItemsBySlug(UserModel $user, $value);
	public function findItemsByType(UserModel $user, $value, $splitByProduct = false);

}