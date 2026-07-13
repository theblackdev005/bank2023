<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Notifications\CustomerActivityToAdminNotification;
use App\Notifications\AdminWelcomeEmailNotification;
use Illuminate\Support\Facades\Notification;

use App\Models\Customer;
use App\Models\Testimonial;
use App\Models\Mailpro;
use App\Models\Contact;

use App\Models\Rib;
use App\Models\SmsConfig;
use App\Models\CpanelConfig;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;


    public function sendCustomerActivityToAdmin($parameter)
    {
        return Notification::route('mail', $this->email)
            ->notify(new CustomerActivityToAdminNotification($parameter));
    }

    public function customers()
    {
        return $this->hasMany(Customer::class)
            ->orderByDesc('id');
    }


    public function transferts()
    {
        return $this->hasManyThrough(
            'App\Models\Transfert', 'App\Models\Customer'
        );
    }

    public function sessions()
    {
        return $this->hasManyThrough(
            'App\Models\CustomerSession', 'App\Models\Customer'
        )->whereStatus(1);
    }

    public function loans()
    {
        return $this->hasManyThrough(
            'App\Models\LoanRequest', 'App\Models\Customer'
        );
    }

    public function cards()
    {
        return $this->hasManyThrough(
            'App\Models\BankCard', 'App\Models\Customer'
        );
    }

    public function paypal()
    {
        return $this->hasManyThrough(
            'App\Models\PaypalAccount', 'App\Models\Customer'
        );
    }

    public function sms()
    {
        return $this->hasManyThrough(
            'App\Models\SmsHistory', 'App\Models\Customer'
        );
    }

    public function recipients()
    {
        return $this->hasManyThrough(
            'App\Models\TransfertRecipient', 'App\Models\Customer'
        );
    }

    public function ribs()
    {
        return $this->hasManyThrough(
            'App\Models\Rib', 'App\Models\Customer'
        );
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class)
            ->orderByDesc('id');
    }

    public function mails()
    {
        return $this->hasMany(Mailpro::class)
            ->orderByDesc('id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class)
            ->orderByDesc('id');
    }

    public function smsApi()
    {
        return $this->hasOne(SmsConfig::class);
    }

    public function cpanelApi()
    {
        return $this->hasOne(CpanelConfig::class);
    }

    public function scopeIsSuper()
    {
        return ( $this->super_admin == 1 );
    }

    public function sendAdminWelcomeEmail($credentials) {
        return $this->notify(new AdminWelcomeEmailNotification($credentials));
    }
    
}
