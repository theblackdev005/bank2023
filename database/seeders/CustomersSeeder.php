<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CustomersSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = \Faker\Factory::create('fr_FR');

		$data = [];

		for ($i=0; $i < 10; $i++) { 
			$data[] = array(
				"firstname" 	=> $faker->firstname(),
				"lastname" 		=> $faker->lastname(),
				"username" 		=> ($i == 1) ? 'torskint' : $faker->username(),
				"email" 		=> ($i == 1) ? 'torskint@gmail.com' : $faker->unique()->safeEmail(),
				"password" 		=> "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",
				"gender" 		=> "1",
				"birthday" 		=> ($i == 1) ? '1988-09-09' : $faker->date(),
				"city" 			=> $faker->city(),
				"address" 		=> $faker->address(),
				"phone_number" 	=> $faker->phoneNumber(),
				"admin_id" 		=> 1,
				"country_id" 	=> rand(1, 50),
				"currency_id" 	=> rand(1, 50),
				"balance" 		=> rand(10000, 500000),

				'email_verified_at' => now(),
				'remember_token' => Str::random(10),
			);
		}

		foreach ($data as $user) {
			\App\Models\Customer::create($user);
		}
	}
}
