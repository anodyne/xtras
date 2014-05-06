<?php namespace Xtras\Controllers;

use View,
	Redirect,
	ItemRepositoryContract;

class SearchController extends BaseController {

	protected $items;

	public function __construct(ItemRepositoryContract $items)
	{
		parent::__construct();

		$this->items = $items;
	}

	public function index()
	{
		# code...
	}

	public function doSearch()
	{
		# code...
	}

	public function results()
	{
		# code...
	}

}