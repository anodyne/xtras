<?php

class ProductSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$products = array(
			array('name' => 'Nova 1'),
			array('name' => 'Nova 2'),
			array('name' => 'Nova 3'),
		);

		foreach ($products as $product)
		{
			Product::create($product);
		}
	}

}