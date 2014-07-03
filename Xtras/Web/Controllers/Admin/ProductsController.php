<?php namespace Xtras\Controllers\Admin;

use View,
	Input,
	Redirect,
	ProductRepositoryInterface;
use Xtras\Controllers\BaseController;

class ProductsController extends BaseController {

	protected $products;

	public function __construct(ProductRepositoryInterface $products)
	{
		parent::__construct();

		$this->products = $products;
	}

	public function index()
	{
		return View::make('pages.admin.products.index')
			->withProducts($this->products->all());
	}

	public function create()
	{
		//
	}

	public function store()
	{
		//
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