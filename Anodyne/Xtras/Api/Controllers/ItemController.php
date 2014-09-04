<?php namespace Xtras\Api\Controllers;

class ItemController extends \Controller {

	protected $items;

	public function __construct(\ItemRepositoryInterface $items)
	{
		$this->items = $items;
	}

	public function index()
	{
		return $this->items->allPaginated(25);
	}

	public function skins($product = false)
	{
		//
	}

	public function ranks($product = false)
	{
		//
	}

	public function mods($product = false)
	{
		//
	}

}