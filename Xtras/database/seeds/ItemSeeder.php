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
				'type_id' => $faker->numberBetween(1, 3),
				'product_id' => $faker->numberBetween(1, 3),
				'name' => 'Pulsar',
				'desc' => $faker->paragraph(10),
				'slug' => '',
			),
			array(
				'user_id' => 1,
				'type_id' => $faker->numberBetween(1, 3),
				'product_id' => $faker->numberBetween(1, 3),
				'name' => 'Titan',
				'desc' => $faker->paragraph(10),
				'slug' => '',
			),
			array(
				'user_id' => 1,
				'type_id' => $faker->numberBetween(1, 3),
				'product_id' => $faker->numberBetween(1, 3),
				'name' => 'Lightness',
				'desc' => $faker->paragraph(10),
				'slug' => '',
			),

			array(
				'user_id' => 2,
				'type_id' => $faker->numberBetween(1, 3),
				'product_id' => $faker->numberBetween(1, 3),
				'name' => 'DS9 Duty Uniform',
				'desc' => $faker->paragraph(10),
				'slug' => '',
			),
			array(
				'user_id' => 2,
				'type_id' => $faker->numberBetween(1, 3),
				'product_id' => $faker->numberBetween(1, 3),
				'name' => 'DS9 Dress Uniform',
				'desc' => $faker->paragraph(10),
				'slug' => '',
			),
			array(
				'user_id' => 2,
				'type_id' => $faker->numberBetween(1, 3),
				'product_id' => $faker->numberBetween(1, 3),
				'name' => 'DS9 Alternate Uniform #1',
				'desc' => $faker->paragraph(10),
				'slug' => '',
			),
			array(
				'user_id' => 2,
				'type_id' => $faker->numberBetween(1, 3),
				'product_id' => $faker->numberBetween(1, 3),
				'name' => 'DS9 Alternate Uniform #2',
				'desc' => $faker->paragraph(10),
				'slug' => '',
			),
			
			array(
				'user_id' => 1,
				'type_id' => $faker->numberBetween(1, 3),
				'product_id' => $faker->numberBetween(1, 3),
				'name' => 'Skinny Bio Page',
				'desc' => $faker->paragraph(10),
				'slug' => '',
			),
			array(
				'user_id' => 1,
				'type_id' => $faker->numberBetween(1, 3),
				'product_id' => $faker->numberBetween(1, 3),
				'name' => 'External Post Archiving',
				'desc' => $faker->paragraph(10),
				'slug' => '',
			),
			array(
				'user_id' => 1,
				'type_id' => $faker->numberBetween(1, 3),
				'product_id' => $faker->numberBetween(1, 3),
				'name' => 'Stardate Display',
				'desc' => $faker->paragraph(10),
				'slug' => '',
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
				'rating' => $faker->numberBetween(1, 5),
			));
		}
	}

}