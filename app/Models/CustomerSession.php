<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class CustomerSession extends Model
{
    use HasFactory;

    const ACTIVE_WINDOW_MINUTES = 5;

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

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];


    public function scopeActive($query)
    {
        return $query->where('status', 1)
            ->where('last_seen_at', '>=', now()->subMinutes(self::ACTIVE_WINDOW_MINUTES));
    }

    public function isActive()
    {
        return $this->status == 1
            && $this->last_seen_at
            && $this->last_seen_at->gte(now()->subMinutes(self::ACTIVE_WINDOW_MINUTES));
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
