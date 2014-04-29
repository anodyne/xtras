<?php

class TypeSeeder extends Seeder {

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
			array('name' => 'MOD'),
		);

		foreach ($types as $type)
		{
			TypeModel::create($type);
		}
	}

}