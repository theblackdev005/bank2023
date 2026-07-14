<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MakeDefaultSiteLanguageEditable extends Migration
{
    public function up()
    {
        DB::table('configs')
            ->where('name', 'DEFAULT_SITE_LANGUAGE')
            ->update(['readonly' => false]);
    }

    public function down()
    {
        DB::table('configs')
            ->where('name', 'DEFAULT_SITE_LANGUAGE')
            ->update(['readonly' => true]);
    }
}
