<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsConfig extends Model
{
    use HasFactory;

    public function scopeIsEnabled()
    {
        return !is_null($this->enabled_at);
    }
}
