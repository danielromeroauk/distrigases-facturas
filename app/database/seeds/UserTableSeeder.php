<?php

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$users = array(
			array(
				'nombre' => 'DANIEL ROMERO GELVEZ',
				'email' => 'danielromeroauk@gmail.com',
				'password' => Hash::make('123'),
				'rol' => 'administrador'
			),
			array(
				'name' => 'LUCERO SANCHEZ',
				'email' => 'distrigases@hotmail.com',
				'password' => Hash::make('123'),
				'rol' => 'administrador'
			)
		);

		DB::table('users')->insert($users);

		$this->command->info('users table seeded.');
	}

}