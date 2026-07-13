<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class EnvFile extends Model
{

    private static $spacerKeyWord = 'space';

    public static function parse(){
        $posts = file(app()->environmentFilePath(), FILE_IGNORE_NEW_LINES);

        $content = [];
        foreach ($posts as $post) {
            if ( empty($post) ) {
                $content[] = self::$spacerKeyWord;
                continue;
            }

            $expl = explode('=', $post);
            $content[ $expl[0] ] = $expl[1];
        }

        return $content;
    }

    public static function get($prefix){
        $data = [];
        foreach (self::parse() as $key => $value) {
            if ( preg_match("/^{$prefix}/", $key) ) {
                $data[$key] = trim($value, '"');
            }
        }
        return $data;
    }

    public static function set(array $posts){
        $contents = self::parse();

        foreach ($posts as $key => $value) {
            $contents[$key] = $value;
        }
        return $contents;
    }

    public static function regenerate(array $posts){
        $content = null;

        foreach ($posts as $key => $value) {
            if ( $value == self::$spacerKeyWord ) {
                $content .= "\n";
            } else {
                if ( preg_match("/^[\$\{]+/", $value) || (strpos($value, " ") !== false) ) {
                    $value = '"' . trim($value, '"')  . '"';
                }
                $content .= "$key=$value\n";
            }
        }

        file_put_contents(app()->environmentFilePath(), $content);

        Artisan::call('cache:clear');
        Artisan::call('config:clear');

        return true;
    }
}
