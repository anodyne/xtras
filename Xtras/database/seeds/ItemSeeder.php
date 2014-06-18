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

		for ($i = 0; $i < 30; $i++)
		{
			$type = $faker->numberBetween(1, 3);

			switch ($type)
			{
				case 1:
					$name = ucfirst($faker->word);
				break;

				case 2:
				case 3:
					$name = ucwords(implode(' ', $faker->words(3)));
				break;
			}

			$item = ItemModel::create([
				'user_id' => $faker->numberBetween(1, 2),
				'type_id' => $type,
				'product_id' => $faker->numberBetween(1, 3),
				'name' => $name,
				'desc' => $faker->paragraph(10),
				'slug' => '',
			]);

			$ratingsLoop = $faker->numberBetween(1, 10);

			for ($j = 1; $j < $ratingsLoop; $j++)
			{
				ItemRatingModel::create([
					'user_id' => $faker->numberBetween(1, 2),
					'item_id' => $item->id,
					'rating' => $faker->numberBetween(1, 5),
				]);
			}
		}
	}

}