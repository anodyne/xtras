<?php namespace Xtras\Repositories\Eloquent;

use Input,
	ProductModel,
	ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface {

	public function all()
	{
		return ProductModel::all();
	}

	public function create(array $data = [], $flashMessage = true)
	{
		# code...
	}

	public function delete($id, $flashMessage = true)
	{
		//
	}

	public function find($id)
	{
		return ProductModel::find($id);
	}

	public function update($id, array $data = [], $flashMessage = true)
	{
		# code...
	}

}