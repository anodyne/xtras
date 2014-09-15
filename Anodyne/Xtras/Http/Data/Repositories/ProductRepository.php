<?php namespace Xtras\Data\Repositories;

use Product,
	Sanitize,
	ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface {

	public function all()
	{
		return Product::active()->get();
	}

	public function create(array $data)
	{
		$data = Sanitize::clean($data, Product::$sanitizeRules);

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
			$data = Sanitize::clean($data, Product::$sanitizeRules);
			
			$product->fill($data)->save();

			return $product;
		}

		return false;
	}

}