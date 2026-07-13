<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RecaptchaSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		\App\Models\GoogleRecaptcha::create([
			"site_key" 		=> '6LfSS5cmAAAAAK_tXG-noZSI3gRSe9kCSTQj5lZM',
			"secret_key" 	=> '6LfSS5cmAAAAAMR6ePsgWyBAXq1deZiVGMEqIWbT',
			"enabled_at" 	=> now(),
		]);
	}
}
