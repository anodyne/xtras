<?php namespace Xtras\Data\Interfaces;

use User;

interface UserRepositoryInterface {

	public function addNotification($userId, $itemId);
	public function all();
	public function find($userId);
	public function findByUsername($username);
	public function findItemsByName(User $user, $value);
	public function findItemsBySlug(User $user, $value);
	public function getItemsByType(User $user);
	public function getNotifications(User $user);
	public function getOrders(User $user);
	public function listAll();
	public function removeNotification($userId, $itemId);
	public function reportSizes();

}