<?php

namespace App;

class TranslationHelper
{
    public static $activeFolder = 'torskint/translation';

    public static function setActiveFolder($folder)
    {
        self::$activeFolder = 'torskint/' . $folder;
    }

    public static function resetActiveFolder()
    {
        self::$activeFolder = 'torskint/translation';
    }

    public static function getText($key)
    {
    	return __( self::$activeFolder . '.TRAD_' . $key );
    }
}