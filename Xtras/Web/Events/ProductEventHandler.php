<?php namespace Xtras\Events;

class ProductEventHandler {

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

}