<?php namespace Xtras\Controllers;

use View,
	Event,
	Input,
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
		$products[''] = "Choose a product";
		$products += $this->items->getProducts();

		$types[''] = "Choose a type";
		$types += $this->items->getItemTypes();

		return View::make('pages.item.create')
			->withProducts($products)
			->withTypes($types);
	}

	public function store()
	{
		// Validate

		// Create
		$item = $this->items->create(Input::all(), false);

		// Fire the item creation event
		Event::fire('item.created', [$item]);

		return Redirect::route('xtra.upload', [$item->id]);
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

	public function upload($id)
	{
		return View::make('pages.item.upload')
			->withItem($this->items->find($id));
	}

	public function ajaxCheckName()
	{
		// Find the items
		$items = $this->items->findByName(Input::get('name'));

		if ($items->count() > 0)
		{
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

}