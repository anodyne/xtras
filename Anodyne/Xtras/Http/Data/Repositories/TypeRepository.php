<?php namespace Xtras\Data\Repositories;

use Type;

class TypeRepository implements \TypeRepositoryInterface {

	public function all()
	{
		return Type::active()->get();
	}

	public function create(array $data)
	{
		return Type::create($data);
	}

	public function delete($typeId)
	{
		// Get the type
		$type = $this->find($typeId);

		if ($type)
		{
			$delete = $type->delete();

			return $type;
		}

		return false;
	}

	public function find($typeId)
	{
		return Type::active()->find($typeId);
	}

	public function update($typeId, array $data)
	{
		// Get the type
		$type = $this->find($typeId);

		if ($type)
		{
			$type->fill($data)->save();

			return $type;
		}

		return false;
	}

}