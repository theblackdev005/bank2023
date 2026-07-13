<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;

class GoogleRecaptcha extends Model
{
    use HasFactory;

    public static function chargeConfig() {
        $setting = Cache::get('db_recaptcha_setting', collect([]));

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
        Cache::forget('db_recaptcha_setting');
        Cache::rememberForever('db_recaptcha_setting', fn() => static::query()->get()->toBase());
    }

    public function scopeIsEnabled()
    {
        return !is_null($this->enabled_at);
    }
}
