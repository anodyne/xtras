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
		$items = $this->items->searchAdvanced(Input::all());

		return Redirect::route('search.results')
			->withTerm(Input::get('search'))
			->withResults($items);
	}

	public function doSearch()
	{
		$items = $this->items->search(Input::get('search'));

		return Redirect::route('search.results')
			->withTerm(Input::get('search'))
			->withResults($items);
	}

	public function results()
	{
		return View::make('pages.search_results')
			->withTerm(Session::get('term'))
			->withResults(Session::get('results'));
	}

}