<?php namespace Xtras\Controllers;

use View,
	Input,
	BaseController,
	ItemRepositoryInterface,
	TypeRepositoryInterface,
	ProductRepositoryInterface;

class SearchController extends BaseController {

	protected $items;
	protected $types;
	protected $products;

	public function __construct(ItemRepositoryInterface $items,
			ProductRepositoryInterface $products,
			TypeRepositoryInterface $types)
	{
		parent::__construct();

		$this->items = $items;
		$this->types = $types;
		$this->products = $products;
	}

	public function advanced()
	{
		return View::make('pages.search_advanced')
			->withTypes($this->types->listAll())
			->withProducts($this->products->listAll());
	}

	public function doAdvancedSearch()
	{
		return View::make('pages.search_results')
			->withTerm(Input::get('q'))
			->withResults($this->items->searchAdvanced(Input::all()));
	}

	public function doSearch()
	{
		return View::make('pages.search_results')
			->withTerm(Input::get('q'))
			->withResults($this->items->search(Input::get('q')));
	}

}