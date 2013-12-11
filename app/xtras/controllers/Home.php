<?php namespace Xtras\Controllers;

use View;
use XtraRepositoryInterface;
use UserRepositoryInterface;

class Home extends Base {

	public function __construct(XtraRepositoryInterface $item,
								UserRepositoryInterface $user)
	{
		$this->item = $item;
		$this->user = $user;
	}

	public function getIndex()
	{
		return View::make('pages.index')
			->with('new', $this->item->getNewest(5))
			->with('updated', $this->item->getRecentlyUpdated(5));
	}

}