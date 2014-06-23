<?php

class RoleSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$roles = [
			['name' => "Xtras Administrator"],
			['name' => "Xtras User (No Rank Sets)"],
			['name' => "Xtras User (Including Rank Sets)"],
		];

		foreach ($roles as $role)
		{
			RoleModel::create($role);
		}

		$permissions = [
			['name' => "Create Xtra", 'display_name' => "xtra.item.create"],
			['name' => "Edit Xtra", 'display_name' => "xtra.item.edit"],
			['name' => "Delete Xtra", 'display_name' => "xtra.item.delete"],
			['name' => "Skin Xtras", 'display_name' => "xtra.item.skins"],
			['name' => "MOD Xtras", 'display_name' => "xtra.item.mods"],
			['name' => "Rank Xtras", 'display_name' => "xtra.item.ranks"],
		];

		foreach ($permissions as $permission)
		{
			PermissionModel::create($permission);
		}
	}

}