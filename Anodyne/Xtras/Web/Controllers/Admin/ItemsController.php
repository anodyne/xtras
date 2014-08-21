<?php namespace Xtras\Controllers\Admin;

use View,
	Input,
	Redirect,
	ItemRepositoryInterface;
use Xtras\Controllers\BaseController;

class ItemsController extends BaseController {

	protected $items;

	public function __construct(ItemRepositoryInterface $items)
	{
		parent::__construct();

		$this->items = $items;
	}

	public function index()
	{
		if ($this->currentUser->can('xtras.admin'))
		{
			// Find all the skins
			$data = $this->items->getByPage(false, Input::get('page', 1), 25, 'name', 'asc');

			// Build the paginator
			$paginator = \Paginator::make($data->items, $data->totalItems, 25);

			return View::make('pages.admin.items.index')
				->withItems($paginator);
		}

		return $this->unauthorized("You do not have permissions to manage Xtras!");
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