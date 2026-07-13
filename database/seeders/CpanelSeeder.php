<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CpanelSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$admin = \App\Models\Admin::first();

		\App\Models\CpanelConfig::create([
			"admin_id" 		=> $admin->id,
			"username" 		=> 'besticvt',
			"apikey" 		=> "JJ9CX3GK4HSP61H2C9OQE28JLSW8XXFL",
			"domain_name" 		=> "bestcenter56.com",
			"enabled_at" 	=> now(),
		]);
	}
}
