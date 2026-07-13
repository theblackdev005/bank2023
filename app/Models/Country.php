<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;


    public function scopeActive($query) {
        return $query->whereNotNull('enabled_at')->get();
    }

    public function scopeIsEnabled(){
        return ! is_null($this->enabled_at);
    }
}
