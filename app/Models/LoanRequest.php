<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Customer;
use App\Models\Currency;

class LoanRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uniqid',
        'customer_id',
        'currency_id',
        'amount',
        'duration',
        'goal',
    ];


    public function scopeIsApproved()
    {
        return ! is_null($this->approved_at);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
