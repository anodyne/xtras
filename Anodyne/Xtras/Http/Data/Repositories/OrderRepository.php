<?php namespace Xtras\Data\Repositories;

class OrderRepository implements \OrderRepositoryInterface {

	public function create(\User $user, \ItemFile $file)
	{
		// Create a new order
		$order = \Order::create([
			'item_id'	=> $file->item->id,
			'file_id'	=> $file->id,
		]);

		// Attach it to the user
		$user->orders()->save($order);
	}

}