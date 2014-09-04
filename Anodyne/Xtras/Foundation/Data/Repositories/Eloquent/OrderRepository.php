<?php namespace Xtras\Foundation\Data\Repositories\Eloquent;

use UserModel,
	OrderModel,
	ItemFileModel,
	OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface {

	public function create(UserModel $user, ItemFileModel $file)
	{
		// Create a new order
		$order = new OrderModel;
		$order->fill([
			'item_id'	=> $file->item->id,
			'file_id'	=> $file->id,
		]);
		$order->save();

		// Attach it to the user
		$user->orders()->save($order);
	}

}