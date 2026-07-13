<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		for ($i=0; $i < 10; $i++) {
			$superAdmin = ($i === 0) ? 1 : 0;
			$key = $i + 229;

			\App\Models\Admin::create([
				"username" 		=> ($i === 0) ? 'admin' : 'admin' . $key,
				"email" 		=> 'napaso'. $key .'@gmail.com',
				"super_admin" 	=> strval( $superAdmin ),
				"password" 		=> "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",
			]);
		}
	}
}
