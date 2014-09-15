<?php namespace Xtras\Data\Repositories;

use User,
	Order,
	ItemFile,
	OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface {

	public function create(User $user, ItemFile $file)
	{
		// Create a new order
		$order = Order::create([
			'item_id'	=> (int) $file->item->id,
			'file_id'	=> (int) $file->id,
		]);

		// Attach it to the user
		$user->orders()->save($order);
	}

}