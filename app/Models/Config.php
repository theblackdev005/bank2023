<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;
use App\Models\EnvFile;

class Config extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'value',
    ];


    public static function chargeConfig() {
        $settings = Cache::get('db_setting', []);

        foreach ($settings as $setting) {
            $constant = strtoupper($setting['name']);

            if ( ! defined($constant) ) {
                define($constant, $setting['value']);
            }

            if ( !empty($setting['auto_set']) ) {
                $data = explode("|", $setting['auto_set']);
                foreach ($data as $keyName) {
                    app('config')->set($keyName, $setting['value']);
                }
            }
        }
    }

    public static function refreshCache() {
        Cache::forget('db_setting');
        Cache::rememberForever('db_setting', fn() => static::query()->get()->toBase());
    }

    public static function generate_env_appName(Config $config)
    {
        if ( $config->name == 'SITE_NAME' ) {
            $posts = EnvFile::set(['APP_NAME' => $config->value]);
            EnvFile::regenerate($posts);
        }
    }

}
