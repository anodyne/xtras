<?php namespace Xtras\Repositories\Eloquent;

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

	public function create(array $data = [], $flashMessage = true)
	{
		// Create the product
		$product = ProductModel::create($data);

		if ($product)
		{
			if ($flashMessage)
			{
				$this->setFlashMessage("success", "Product was successfully created.");
			}
			
			return $product;
		}

		return false;
	}

	public function delete($id, $flashMessage = true)
	{
		// Get the product
		$product = $this->find($id);

		if ($product)
		{
			$delete = $product->delete();
			\Log::info($delete);

			if ($flashMessage)
			{
				$this->setFlashMessage('success', "Product was successfully deleted.");
			}

			return $product;
		}

		return false;
	}

	public function find($id)
	{
		return ProductModel::find($id);
	}

	public function update($id, array $data = [], $flashMessage = true)
	{
		// Get the product
		$product = $this->find($id);

		if ($product)
		{
			$product->fill($data);
			$product->save();

			if ($flashMessage)
			{
				$this->setFlashMessage('success', "Product was sucessfully updated.");
			}

			return $product;
		}

		return false;
	}

}