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

		for ($i = 0; $i < 100; $i++)
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
				'user_id' => $faker->numberBetween(1, 25),
				'type_id' => $type,
				'product_id' => $faker->numberBetween(1, 3),
				'name' => $name,
				'desc' => $faker->paragraph(10),
				'slug' => '',
			]);

			// Create a new meta model
			$meta = new ItemMetaModel;
			$meta->fill([
				'item_id' => $item->id,
				'installation' => implode("\r\n\r\n", $faker->paragraphs(3)),
				'history' => $faker->paragraph,
			]);
			$meta->save();

			// Determine how many times we're looping through ratings
			$ratingsLoop = $faker->numberBetween(1, 10);

			for ($j = 1; $j < $ratingsLoop; $j++)
			{
				ItemRatingModel::create([
					'user_id' => $faker->numberBetween(1, 2),
					'item_id' => $item->id,
					'rating' => $faker->numberBetween(1, 5),
				]);
			}

			// Determine how many times we're looping through comments
			$commentsLoop = $faker->numberBetween(1, 10);

			for ($c = 1; $c < $commentsLoop; $c++)
			{
				CommentModel::create([
					'user_id' => $faker->numberBetween(1, 2),
					'item_id' => $item->id,
					'content' => $faker->paragraph,
				]);
			}

			// Determine how many times we're looping through files
			$filesLoop = $faker->numberBetween(1, 10);

			for ($f = 1; $f < $filesLoop; $f++)
			{
				$version = $faker->randomFloat(1, 1, 9);
				$filename = "{$item->user->username}/{$item->slug}-{$version}.zip";

				ItemFileModel::create([
					'item_id' => $item->id,
					'filename' => $filename,
					'version' => $faker->randomFloat(1, 1, 9),
				]);
			}

			$item->update(['version' => $version]);
		}
	}

}