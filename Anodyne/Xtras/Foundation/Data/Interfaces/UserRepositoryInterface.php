<?php namespace Xtras\Foundation\Data\Interfaces;

use UserModel;

interface UserRepositoryInterface extends BaseRepositoryInterface {

	public function addNotification($user, $item);
	public function findByUsername($username);
	public function findItemsByName(UserModel $user, $value);
	public function findItemsBySlug(UserModel $user, $value);
	public function findItemsByType(UserModel $user, $value, $splitByProduct = false);
	public function getItemsByType(UserModel $user);
	public function getNotifications(UserModel $user);
	public function removeNotification($user, $item);

}