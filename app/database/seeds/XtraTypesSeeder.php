<?php

class XtraTypesSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$types = array(
			array('name' => 'Skin'),
			array('name' => 'Rank Set'),
			array('name' => 'Mod'),
		);

		foreach ($types as $type)
		{
			XtraType::create($type);
		}
	}

}