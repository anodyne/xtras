<?php namespace Xtras\Repositories\Eloquent;

use Input,
	TypeModel,
	UtilityTrait,
	TypeRepositoryInterface;

class TypeRepository implements TypeRepositoryInterface {

	use UtilityTrait;

	public function all()
	{
		return TypeModel::get();
	}

	public function create(array $data = [], $flashMessage = true)
	{
		// Create the type
		$type = TypeModel::create($data);

		if ($type)
		{
			if ($flashMessage)
			{
				$this->setFlashMessage("success", "Item type was successfully created.");
			}
			
			return $type;
		}

		return false;
	}

	public function delete($id, $flashMessage = true)
	{
		// Get the type
		$type = $this->find($id);

		if ($type)
		{
			$delete = $type->delete();

			if ($flashMessage)
			{
				$this->setFlashMessage('success', "Item type was successfully deleted.");
			}

			return $type;
		}

		return false;
	}

	public function find($id)
	{
		return TypeModel::find($id);
	}

	public function update($id, array $data = [], $flashMessage = true)
	{
		// Get the type
		$type = $this->find($id);

		if ($type)
		{
			$type->fill($data);
			$type->save();

			if ($flashMessage)
			{
				$this->setFlashMessage('success', "Item type was sucessfully updated.");
			}

			return $type;
		}

		return false;
	}

}