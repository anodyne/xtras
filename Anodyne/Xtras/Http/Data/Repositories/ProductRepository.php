<?php namespace Xtras\Data\Repositories;

use Product,
	Sanitize,
	ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface {

	/**
	 * Get all active products.
	 *
	 * @param	bool	$onlyActive	Only get active items?
	 * @return	Collection
	 */
	public function all($onlyActive = true)
	{
		if ($onlyActive)
		{
			return Product::active()->get();
		}

		return Product::get();
	}

	/**
	 * Create a new product.
	 *
	 * @param	array	$data	Data to use for creating the product
	 * @return	Product
	 */
	public function create(array $data)
	{
		// Sanitize the data
		$data = Sanitize::clean($data, Product::$sanitizeRules);

		return Product::create($data);
	}

	/**
	 * Delete a product.
	 *
	 * @param	int		$productId	The product ID to delete
	 * @return	Product/bool
	 */
	public function delete($productId)
	{
		// Get the product
		$product = $this->find($productId);

		if ($product)
		{
			// Delete the product
			$delete = $product->delete();

			return $product;
		}

		return false;
	}

	/**
	 * Find a product based on its ID.
	 *
	 * @param	int		$productId	The product ID to find
	 * @return	Product
	 */
	public function find($productId)
	{
		return Product::active()->find($productId);
	}

	/**
	 * Get the active products as an array.
	 *
	 * @param	string	$label
	 * @param	string	$value
	 * @return	array
	 */
	public function listAll($label = 'name', $value = 'id')
	{
		return Product::active()->lists($label, $value);
	}

	/**
	 * Update a product.
	 *
	 * @param	int		$productId	The product ID to update
	 * @param	array	$data		Data to use for the update
	 * @return	Product
	 */
	public function update($productId, array $data)
	{
		// Get the product
		$product = $this->find($productId);

		if ($product)
		{
			// Sanitize the data
			$data = Sanitize::clean($data, Product::$sanitizeRules);
			
			// Fill and save the information
			$product->fill($data)->save();

			return $product;
		}

		return false;
	}

}