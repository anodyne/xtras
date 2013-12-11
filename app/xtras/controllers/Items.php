<?php namespace Xtras\Controllers;

use View;
use XtraRepositoryInterface;

class Items extends Base {

	public function __construct(XtraRepositoryInterface $item)
	{
		$this->item = $item;
	}

	public function getItem($name)
	{
		return View::make('pages.item')
			->with('skin', $this->item->find($name));
	}

	public function getItems()
	{
		# code...
	}

}