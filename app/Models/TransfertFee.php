<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Transfert;
use App\Models\Customer;
use App\Models\Currency;

use Carbon\Carbon;

class TransfertFee extends Model
{
    use HasFactory;

    public function scopeIsPayed()
    {
        return ! is_null($this->payed_at);
    }

    public function scopeIsExpired()
    {
        $NOW            = Carbon::now();
        $TARGET_TIME    = Carbon::parse($this->load_at);

        return ($NOW->diffInSeconds($TARGET_TIME, false) <= 0);
    }


    public function transfert()
    {
        return $this->belongsTo(Transfert::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'transfert_currency_id', 'id');
    }
}
