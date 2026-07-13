<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enabled_at',
    ];

    public function scopeActive($query) {
        return $query->whereNotNull('enabled_at')->get();
    }

    public function scopeQyActive($query) {
        return $query->whereNotNull('enabled_at');
    }

    public function scopeIsEnabled(){
        return ! is_null($this->enabled_at);
    }
}
