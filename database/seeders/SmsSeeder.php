<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class SmsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$admin = \App\Models\Admin::first();

		\App\Models\SmsConfig::create([
			"admin_id" 		=> $admin->id,
			"username" 		=> 'torskint',
			"password" 		=> "Passed00229",
			"sender" 		=> "Napaso",
			"enabled_at" 	=> now(),
		]);
	}
}
