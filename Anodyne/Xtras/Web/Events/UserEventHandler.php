<?php namespace Xtras\Events;

class UserEventHandler {

	public function onCreate($data)
	{
		// Grab the item out of the array
		$item = $data['item'];
	}

	public function onDelete($data)
	{
		// Grab the item out of the array
		$item = $data['item'];
	}

	public function onUpdate($data)
	{
		// Grab the item out of the array
		$item = $data['item'];
	}

	public function onRegister($data)
	{
		// Grab the item out of the array
		$item = $data['item'];

		// If this is an update, grab the orders and notify anyone who's grabbed this before
	}

}