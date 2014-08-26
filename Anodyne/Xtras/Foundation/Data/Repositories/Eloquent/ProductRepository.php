<?php namespace Xtras\Foundation\Data\Repositories\Eloquent;

use Input,
	ProductModel,
	UtilityTrait,
	ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface {

	use UtilityTrait;

	public function all()
	{
		return ProductModel::get();
	}

	public function create(array $data = [])
	{
		return ProductModel::create($data);
	}

	public function delete($id)
	{
		// Get the product
		$product = $this->find($id);

		if ($product)
		{
			$delete = $product->delete();

			return $product;
		}

		return false;
	}

	public function find($id)
	{
		return ProductModel::find($id);
	}

	public function update($id, array $data = [])
	{
		// Get the product
		$product = $this->find($id);

		if ($product)
		{
			$product->fill($data);
			$product->save();

			return $product;
		}

		return false;
	}

}