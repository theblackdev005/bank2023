<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LanguagesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$currencies = [
			'en' => 'English',
			'fr' => 'Français',
			'de' => 'Deutsch',
			'bg' => 'български',
			'da' => 'dansk',
			'es' => 'Español',
			'it' => 'italiano',
			'lb' => 'Lëtzebuergesch',
			'lt' => 'lietuvių"',
			'lv' => 'latviski',
			'ro' => 'Română',
			'sv' => 'svenska',
			'et' => 'eesti keel',
			'pt' => 'português',
			'no' => 'norsk',
			'fi' => 'Suomalainen',
			'ru' => 'русский',
			'nl' => 'Nederlands',
			'sl' => 'Slovenščina',
			'mn' => 'Монгол',
			'hu' => 'Magyar',
			'el' => 'Ελληνικά',
			'pl' => 'Polskie',
			'uz' => 'o\'zbek',
			'hr' => 'Hrvatski',
			'ky' => 'Кыргызча',
			'hy' => 'հայերեն',
			'kk' => 'қазақ',
			'tg' => 'точикон',
			'tr' => 'Türk',
			'sk' => 'Slovenský',
			'sq' => 'Shqiptare',
		];
		foreach ($currencies as $iso => $name) {

			$enabled_at = null;
			if ( app()->environment('local') ) {
				// $enabled_at = ($iso === 'en') ? now() : null;
			}

			\App\Models\Language::create(compact('name', 'iso', 'enabled_at'));
		}
	}
}
