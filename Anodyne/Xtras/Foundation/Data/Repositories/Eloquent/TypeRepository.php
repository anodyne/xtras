<?php namespace Xtras\Foundation\Data\Repositories\Eloquent;

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

	public function create(array $data = [])
	{
		return TypeModel::create($data);
	}

	public function delete($id)
	{
		// Get the type
		$type = $this->find($id);

		if ($type)
		{
			$delete = $type->delete();

			return $type;
		}

		return false;
	}

	public function find($id)
	{
		return TypeModel::find($id);
	}

	public function update($id, array $data = [])
	{
		// Get the type
		$type = $this->find($id);

		if ($type)
		{
			$type->fill($data);
			$type->save();

			return $type;
		}

		return false;
	}

}