<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
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
        $settings = collect(Cache::get('db_setting', []));

        if ($settings->isEmpty() && Schema::hasTable('configs')) {
            $settings = static::query()->get()->toBase();
            Cache::forever('db_setting', $settings);
        }

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
        Cache::forever('db_setting', static::query()->get()->toBase());
    }

    public static function generate_env_appName(Config $config)
    {
        if ( $config->name == 'SITE_NAME' ) {
            $posts = EnvFile::set(['APP_NAME' => $config->value]);
            EnvFile::regenerate($posts);
        }
    }

}
