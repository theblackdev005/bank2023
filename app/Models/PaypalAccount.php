<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Customer;

class PaypalAccount extends Model
{
    use HasFactory;


    public function scopeIsApproved()
    {
        return ! is_null($this->approved_at);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
