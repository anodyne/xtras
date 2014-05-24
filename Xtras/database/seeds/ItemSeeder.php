<?php

class ItemSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker\Factory::create();

		$items = array(
			array(
				'user_id' => 1,
				'type_id' => 1,
				'product_id' => 3,
				'name' => 'Pulsar',
				'desc' => $faker->paragraph(10),
			),
			array(
				'user_id' => 1,
				'type_id' => 2,
				'product_id' => 3,
				'name' => 'DS9 Duty Uniform',
				'desc' => $faker->paragraph(10),
			),
			array(
				'user_id' => 1,
				'type_id' => 3,
				'product_id' => 3,
				'name' => 'Skinny Bio Page',
				'desc' => $faker->paragraph(10),
			),
		);

		foreach ($items as $item)
		{
			ItemModel::create($item);
		}

		for ($i = 0; $i < 20; $i++)
		{
			ItemRatingModel::create(array(
				'user_id' => 1,
				'item_id' => 1,
				'rating' => $faker->randomNumber(1, 5),
			));
		}
	}

}