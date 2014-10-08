<?php namespace Xtras\Controllers\Admin;

use View,
	Event,
	Input,
	Redirect,
	BaseController,
	ProductValidator,
	ProductRepositoryInterface;

class ProductsController extends BaseController {

	protected $products;
	protected $validator;

	public function __construct(ProductRepositoryInterface $products,
			ProductValidator $validator)
	{
		parent::__construct();

		$this->products = $products;
		$this->validator = $validator;

		// Before filter to check if the user has permissions
		$this->beforeFilter('@checkPermissions');
	}

	public function index()
	{
		return View::make('pages.admin.products.index')
			->withProducts($this->products->all(false));
	}

	public function create()
	{
		return partial('modal_content', [
			'modalHeader'	=> "Create Product",
			'modalBody'		=> View::make('pages.admin.products.create'),
			'modalFooter'	=> false,
		]);
	}

	public function store()
	{
		// Validate the product
		$this->validator->validate(Input::all());

		// Create the product
		$product = $this->products->create(Input::all());

		// Fire the event
		Event::fire('product.created', [$product]);

		return Redirect::route('admin.products.index');
	}

	public function edit($id)
	{
		// Get the product
		$product = $this->products->find($id);

		return partial('modal_content', [
			'modalHeader'	=> "Edit Product",
			'modalBody'		=> View::make('pages.admin.products.edit')->withProduct($product),
			'modalFooter'	=> false,
		]);
	}

	public function update($id)
	{
		// Validate the product
		$this->validator->validate(Input::all());

		// Update the product
		$product = $this->products->update($id, Input::all());

		// Fire the event
		Event::fire('product.updated', [$product]);

		return Redirect::route('admin.products.index');
	}

	public function remove($id)
	{
		// Get the product
		$product = $this->products->find($id);

		return partial('modal_content', [
			'modalHeader'	=> "Remove Product",
			'modalBody'		=> View::make('pages.admin.products.remove')->withProduct($product),
			'modalFooter'	=> false,
		]);
	}

	public function destroy($id)
	{
		// Remove the product
		$product = $this->products->delete($id);

		// Fire the event
		Event::fire('product.deleted', [$product]);

		return Redirect::route('admin.products.index');
	}

	public function checkPermissions()
	{
		if ( ! $this->currentUser->can('xtras.admin'))
		{
			return $this->errorUnauthorized("You do not have permission to manage products!");
		}
	}

}