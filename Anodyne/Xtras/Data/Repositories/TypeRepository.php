<?php namespace Xtras\Data\Repositories;

use Type,
	User,
	Sanitize,
	TypeRepositoryInterface;

class TypeRepository implements TypeRepositoryInterface {

	/**
	 * Get all active item types.
	 *
	 * @param	bool	$onlyActive	Only get active items?
	 * @return	Collection
	 */
	public function all($onlyActive = true)
	{
		if ($onlyActive)
		{
			return Type::active()->get();
		}

		return Type::get();
	}

	/**
	 * Create a new item type.
	 *
	 * @param	array	$data	Data to use for creating the item type
	 * @return	Type
	 */
	public function create(array $data)
	{
		// Sanitize the data
		$data = Sanitize::clean($data, Type::$sanitizeRules);

		return Type::create($data);
	}

	/**
	 * Delete an item type.
	 *
	 * @param	int		$typeId	The item type ID to delete
	 * @return	Type/bool
	 */
	public function delete($typeId)
	{
		// Get the item type
		$type = $this->find($typeId);

		if ($type)
		{
			// Delete the item type
			$delete = $type->delete();

			return $type;
		}

		return false;
	}

	/**
	 * Find an item type based on its ID.
	 *
	 * @param	int		$typeId	The item type ID to find
	 * @return	Type
	 */
	public function find($typeId)
	{
		return Type::active()->find($typeId);
	}

	/**
	 * Get an array of types based on the passed user's permissions.
	 *
	 * @param	User	$user
	 * @param	string	$label
	 * @param	string	$value
	 * @return	array
	 */
	public function getByPermissions(User $user, $label = 'name', $value = 'id')
	{
		// Get all the types
		$types = Type::active()->get();

		// Start an array of items
		$finalTypes = [];

		foreach ($types as $type)
		{
			switch ($type->name)
			{
				case 'Skin':
					if ($user->can('xtras.item.skins'))
					{
						$finalTypes[$type->{$value}] = $type->{$label};
					}
				break;

				case 'MOD':
					if ($user->can('xtras.item.mods'))
					{
						$finalTypes[$type->{$value}] = $type->{$label};
					}
				break;

				case 'Rank Set':
					if ($user->can('xtras.item.ranks'))
					{
						$finalTypes[$type->{$value}] = $type->{$label};
					}
				break;
			}
		}

		return $finalTypes;
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
		return Type::active()->lists($label, $value);
	}

	/**
	 * Update an item type.
	 *
	 * @param	int		$typeId	The item type ID to update
	 * @param	array	$data	Data to use for the update
	 * @return	Type
	 */
	public function update($typeId, array $data)
	{
		// Get the type
		$type = $this->find($typeId);

		if ($type)
		{
			// Sanitize the data
			$data = Sanitize::clean($data, Type::$sanitizeRules);
			
			// Fill and save the information
			$type->fill($data)->save();

			return $type;
		}

		return false;
	}

}