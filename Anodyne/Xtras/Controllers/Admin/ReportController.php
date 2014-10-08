<?php namespace Xtras\Controllers\Admin;

use View,
	Paginator,
	BaseController,
	ItemRepositoryInterface,
	UserRepositoryInterface;

class ReportController extends BaseController {

	protected $items;
	protected $users;

	public function __construct(ItemRepositoryInterface $items,
			UserRepositoryInterface $users)
	{
		parent::__construct();

		$this->items = $items;
		$this->users = $users;

		// Before filter to check if the user has permissions
		$this->beforeFilter('@checkPermissions');
	}

	public function items()
	{
		// Get all the items
		$items = $this->items->reportSizes();

		// Build the paginator
		$paginator = Paginator::make($items, count($items), 25);

		return View::make('pages.admin.reports.items')
			->withItems($paginator);
	}

	public function users()
	{
		// Get all the items
		$items = $this->users->reportSizes();

		// Build the paginator
		$paginator = Paginator::make($items, count($items), 25);

		return View::make('pages.admin.reports.users')
			->withItems($paginator);
	}

	public function checkPermissions()
	{
		if ( ! $this->currentUser->can('xtras.admin'))
		{
			return $this->errorUnauthorized("You do not have permission to view reports!");
		}
	}

}