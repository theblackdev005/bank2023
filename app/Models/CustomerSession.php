<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class CustomerSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'last_seen_at',
        'ip_address',
        'user_agent',
    ];


    public function scopeIsActive()
    {
        return ($this->status == 1);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
