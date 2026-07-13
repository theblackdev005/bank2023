<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;
use App\Models\Config as ConfigModel;
use App\Models\GoogleRecaptcha;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ConfigModel::chargeConfig();
        GoogleRecaptcha::chargeConfig();

        Schema::defaultStringLength(191);

        Blade::directive('selected_if', function ($condition) {
            return "<?= ($condition ?  'selected=\"selected\"' : ''); ?>";
        });

        Blade::directive('disabled', function ($condition) {
            return "<?= ($condition ?  'disabled=\"disabled\"' : ''); ?>";
        });

        Blade::directive('checked', function ($condition) {
            return "<?= ($condition ?  'checked=\"checked\"' : ''); ?>";
        });

        Validator::extend('phone_number', function ($attribute, $value, $parameters, $validator) {
            return preg_match("/^[0-9\+]+$/", $value);
        }, translate(730));
    }
}
