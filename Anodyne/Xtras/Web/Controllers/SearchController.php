<?php namespace Xtras\Controllers;

use View,
	Input,
	Session,
	Redirect,
	ItemRepositoryInterface;

class SearchController extends BaseController {

	protected $items;

	public function __construct(ItemRepositoryInterface $items)
	{
		parent::__construct();

		$this->items = $items;
	}

	public function advanced()
	{
		return View::make('pages.search_advanced')
			->withTypes($this->items->getTypes())
			->withProducts($this->items->getProducts());
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