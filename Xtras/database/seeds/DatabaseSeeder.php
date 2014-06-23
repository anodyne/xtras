<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Get the environment
		$env = App::environment();

		// Unguard the models
		Eloquent::unguard();

		$this->call('TypeSeeder');
		$this->call('ProductSeeder');
		//$this->call('RoleSeeder');

		if ($env != 'production')
		{
			$this->call('ItemSeeder');
			$this->call('UserSeeder');
		}
	}

}