<?php

class ItemTypesSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$types = array(
			array('type' => 'Skin'),
			array('type' => 'Rank Set'),
			array('type' => 'Mod'),
		);

		foreach ($types as $type)
		{
			ItemType::create($type);
		}
	}

}