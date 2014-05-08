<?php namespace Xtras\Controllers;

use View,
	Redirect,
	ItemRepositoryContract;

class ItemController extends BaseController {

	protected $items;

	public function __construct(ItemRepositoryContract $items)
	{
		parent::__construct();

		$this->items = $items;
	}

	public function index()
	{
		//
	}

	public function create()
	{
		//
	}

	public function store()
	{
		//
	}

	public function show($id)
	{
		// Get the item by its ID
		$item = $this->items->find($id);

		if ($item)
		{
			return View::make('pages.item.show')->withItem($item);
		}

		// TODO: couldn't find the item
	}

	public function edit($id)
	{
		//
	}

	public function update($id)
	{
		//
	}

	public function destroy($id)
	{
		//
	}

}