<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Country;
use App\Models\Currency;

class TransfertRecipient extends Model
{
    use HasFactory;


    public function scopeIsApproved()
    {
        return !is_null($this->approved_at);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'bank_country_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
