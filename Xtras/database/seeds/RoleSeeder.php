<?php

class RoleSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$permissions = [
			['display_name' => "Create Xtra", 'name' => "xtras.item.create"],
			['display_name' => "Edit Xtra", 'name' => "xtras.item.edit"],
			['display_name' => "Delete Xtra", 'name' => "xtras.item.delete"],
			['display_name' => "Skin Xtras", 'name' => "xtras.item.skins"],
			['display_name' => "MOD Xtras", 'name' => "xtras.item.mods"],
			['display_name' => "Rank Xtras", 'name' => "xtras.item.ranks"],
			['display_name' => "Xtras Admin", 'name' => "xtras.admin"],
		];

		foreach ($permissions as $permission)
		{
			PermissionModel::create($permission);
		}

		$roles = [
			['name' => "Xtras Administrator"],
			['name' => "Xtras User (No Rank Sets)"],
			['name' => "Xtras User (Including Rank Sets)"],
		];

		$roleAssociations = [
			1 => [1, 2, 3, 4, 5, 6, 7],
			2 => [1, 2, 3, 4, 5],
			3 => [1, 2, 3, 4, 5, 6],
		];

		foreach ($roles as $role)
		{
			$role = RoleModel::create($role);

			foreach ($roleAssociations[$role->id] as $ra)
			{
				$role->perms()->attach($ra);
			}
		}
	}

}