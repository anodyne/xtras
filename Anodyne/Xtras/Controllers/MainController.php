<?php namespace Xtras\Controllers;

use View,
	Input,
	BaseController,
	ItemRepositoryInterface;

class MainController extends BaseController {

	protected $items;

	public function __construct(ItemRepositoryInterface $items)
	{
		parent::__construct();

		$this->items = $items;
	}

	public function index()
	{
		return View::make('pages.main')
			->withNew($this->items->getRecentlyAdded(9))
			->withUpdated($this->items->getRecentlyUpdated(9));
	}

	public function policies($type = false)
	{
		switch ($type)
		{
			case 'browsers':
				$view = 'pages.policies.browsers';
			break;

			case 'privacy':
				$view = 'pages.policies.privacy';
			break;

			case 'terms':
				$view = 'pages.policies.terms';
			break;

			default:
				$view = 'pages.policies.index';
			break;
		}

		return View::make($view);
	}

	public function faq()
	{
		return View::make('pages.faq');
	}

	public function markdown()
	{
		return View::make('pages.markdown');
	}

	public function gettingStarted()
	{
		return View::make('pages.start');
	}

}