<?php namespace Xtras\Foundation\Data\Interfaces;

use User;

interface UserRepositoryInterface {

	public function addNotification($userId, $itemId);
	public function all();
	public function find($userId);
	public function findByUsername($username);
	public function findItemsByName(User $user, $value);
	public function findItemsBySlug(User $user, $value);
	public function findItemsByType(User $user, $value, $splitByProduct = false);
	public function getItemsByType(User $user);
	public function getNotifications(User $user);
	public function getOrders(User $user);
	public function removeNotification($userId, $itemId);

}