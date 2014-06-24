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
			],
			[
				'name'		=> "David VanScott",
				'email'		=> "davidv@anodyne-productions.com",
				'password'	=> "password",
				'url'		=> "http://concurrent-studios.com",
				'slug'		=> '',
			]
		];

		foreach ($users as $user)
		{
			$user = UserModel::create($user);

			// Attach the Xtras Administrator role
			$user->roles()->attach(1);
		}
	}

}