<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class GoogleRecaptcha extends Model
{
    use HasFactory;

    public static function chargeConfig() {
        $setting = collect(Cache::get('db_recaptcha_setting', []));

        if ($setting->isEmpty()) {
            try {
                if (Schema::hasTable('google_recaptchas')) {
                    $setting = static::query()->get()->toBase();
                    Cache::forever('db_recaptcha_setting', $setting);
                }
            } catch (\Throwable $e) {
                // Recaptcha remains disabled until installation configures the database.
                $setting = collect();
            }
        }

        $setting = $setting->whereNotNull('enabled_at');

        if ( ! defined('GOOGLE_RECAPTCHA_ENABLED') ) {
            define('GOOGLE_RECAPTCHA_ENABLED', $setting->count() > 0 );
        }

        if ( GOOGLE_RECAPTCHA_ENABLED ) {
            $setting = $setting->first();
            
            define('GOOGLE_RECAPTCHA_KEY', $setting['site_key'] );
            define('GOOGLE_RECAPTCHA_SECRET', $setting['secret_key'] );
        }
    }

    public static function refreshCache() {
        Cache::forever('db_recaptcha_setting', static::query()->get()->toBase());
    }

    public function scopeIsEnabled()
    {
        return !is_null($this->enabled_at);
    }
}
