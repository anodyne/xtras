<?php

class UserSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$users = [
			[
				'name'		=> "Anodyne Productions",
				'email'		=> "admin@anodyne-productions.com",
				'password'	=> "password",
				'url'		=> "http://anodyne-productions.com",
				'slug'		=> '',
				'avatar'	=> "anodyneproductions.jpg",
				'access'	=> 1,
			],
			[
				'name'		=> "David VanScott",
				'email'		=> "davidv@anodyne-productions.com",
				'password'	=> "password",
				'url'		=> "http://concurrent-studios.com",
				'slug'		=> '',
				'access'	=> 2,
			]
		];

		$faker = Faker\Factory::create();

		for ($i = 1; $i <= 23; $i++)
		{
			$users[] = [
				'name' => $faker->firstName(null)." ".$faker->lastName(null),
				'email' => $faker->safeEmail,
				'password' => 'password',
				'url' => $faker->url,
				'slug' => '',
				'access' => $faker->numberBetween(2, 3),
			];
		}

		foreach ($users as $user)
		{
			$access = (int) $user['access'];
			unset($user['access']);

			$user = UserModel::create($user);

			// Attach the Xtras Administrator role
			$user->roles()->attach($access);
		}
	}

}