<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if ( app()->environment('local') ) {
            // $this->call(AdminsSeeder::class);
            // $this->call(SmsSeeder::class);
            // $this->call(CpanelSeeder::class);
            // $this->call(RecaptchaSeeder::class);
            // $this->call(CustomersSeeder::class);
        }

        $this->call(ConfigsSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(CurrenciesSeeder::class);
        $this->call(LanguagesSeeder::class);

        Artisan::call('update:db-config');
    }
}
