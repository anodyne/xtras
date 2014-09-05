<?php namespace Xtras\Foundation\Data\Repositories;

use Product;

class ProductRepository implements \ProductRepositoryInterface {

	public function all()
	{
		return Product::active()->all();
	}

	public function create(array $data)
	{
		return Product::create($data);
	}

	public function delete($productId)
	{
		// Get the product
		$product = $this->find($productId);

		if ($product)
		{
			$delete = $product->delete();

			return $product;
		}

		return false;
	}

	public function find($productId)
	{
		return Product::active()->find($productId);
	}

	public function update($productId, array $data)
	{
		// Get the product
		$product = $this->find($productId);

		if ($product)
		{
			$product->fill($data)->save();

			return $product;
		}

		return false;
	}

}