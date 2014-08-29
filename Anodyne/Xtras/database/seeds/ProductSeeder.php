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

		// In production, don't use Nova 3 for now
		if (App::environment() == 'production')
		{
			$products[2]['display'] = (int) false;
		}

		foreach ($products as $product)
		{
			ProductModel::create($product);
		}
	}

}