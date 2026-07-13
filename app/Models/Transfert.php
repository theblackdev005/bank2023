<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransfertFee;
use App\Models\TransfertRecipient;
use Illuminate\Support\Facades\DB;

use App\Models\Customer;
use App\Models\Currency;

class Transfert extends Model
{
    use HasFactory;


    public function scopeIsCompleted()
    {
        return ! is_null($this->completed_at);
    }

    public function scopeRecipient($query)
    {
        return DB::table($this->payment_method)
            ->whereId($this->payment_method_id);
    }

    public function scopepm_currency()
    {
        $recipient = DB::table($this->payment_method)
            ->whereId($this->payment_method_id)->first();

        if ( is_null($id = optional($recipient)->currency_id) ) {
            return false;
        }
        $currency = Currency::whereId($id)->first();

        return $currency;
    }

    public function scopePaidFees()
    {
        return $this->fees()->whereNotNull('payed_at');
    }

    public function scopeUnpaidFees()
    {
        return $this->fees()->whereNull('payed_at');
    }

    public function scopeCurrentPendingFee()
    {
        $get = $this->unpaidFees();
        if ( !$get->count() ) {
            return false;
        }
        return $get->first();
    }

    public function scopeCurrentPayedFee()
    {
        $get = $this->paidFees();
        if ( !$get->count() ) {
            return false;
        }
        return $get->get()->last();
    }



    public function fees()
    {
        return $this->hasMany(TransfertFee::class)->orderBy('percentage');
    }

    public function bankAccount()
    {
        return $this->belongsTo(TransfertRecipient::class, 'payment_method_id', 'id');
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
