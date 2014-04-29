<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('TypeSeeder');
		$this->call('ProductSeeder');
		$this->call('ItemSeeder');
	}

}