<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Rib;
use App\Models\Admin;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Transfert;
use App\Models\Transaction;
use App\Models\LoanRequest;
use App\Models\BankCard;
use App\Models\PaypalAccount;
use App\Models\CustomerSession;
use App\Models\TransfertFee;
use App\Models\TransfertRecipient;

use App\Notifications\PasswordResetNotification;
use App\Notifications\SuccessfulPasswordResetNotification;

use App\Notifications\RegistrationNotification;
use App\Notifications\AccountVerifiedNotification;
use App\Notifications\AccountCancelledNotification;
use App\Notifications\PasswordChangeNotification;
use App\Notifications\AccountBannedOrNotNotification;
use App\Notifications\IdentityVerifiedNotification;
use App\Notifications\RibUpdatedNotification;
use App\Notifications\RibDeletedNotification;
use App\Notifications\FeePaidNotification;
use App\Notifications\TransferInitiatedNotification;
use App\Notifications\TransferFeeCodeNotification;

use App\Notifications\LoanInitiatedNotification;
use App\Notifications\LoanRequestNotification;
use App\Notifications\BankCardRequestNotification;
use App\Notifications\PaypalRequestNotification;
use App\Notifications\RecipientRequestNotification;

use Illuminate\Contracts\Translation\HasLocalePreference;

class Customer extends Authenticatable implements HasLocalePreference
{ 
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'banned_at' => 'datetime',
        'first_login_at' => 'datetime',
        'birthday' => 'date',
    ];

    private $transactionGroupedByDate_paginate  = true;
    private $transactionGroupedByDate_reorder   = false;


    /**
     * Get the user's preferred locale.
     *
     * @return string
     */
    public function preferredLocale() {
        if ( is_null($this->language) ) {
            return DEFAULT_SITE_LANGUAGE;
        }
        return $this->language->iso;
    }


    protected static function booted () {
        static::deleting(function(Customer $customer) {
            // before delete() method call this
            $customer->transferts()->delete();
            $customer->transactions()->delete();
            $customer->loans()->delete();
            $customer->cards()->delete();
            $customer->paypal()->delete();
            $customer->recipients()->delete();
            $customer->sessions()->delete();
            $customer->rib()->delete();
        });
    }


    public function scopeIsBanned() {
        return ! is_null($this->banned_at);
    }

    public function scopeIsPending() {
        return is_null($this->email_verified_at);
    }

    public function scopeIsVerifiedIdentity() {
        return ! is_null($this->identity_verified_at);
    }

    public function scopeIsVerified() {
        return ! is_null($this->email_verified_at);
    }

    public function scopeQyVerified($query) {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeQyBanned($query) {
        return $query->whereNotNull('banned_at');
    }

    public function scopeQyVerifiedAndActif($query) {
        return $query->whereNotNull('email_verified_at')
            ->whereNull('banned_at');
    }

    public function scopeFullname() {
        return ( $this->firstname . ' ' . $this->lastname);
    }

    public function updateLoginAt() {
        if ( ! $this->first_login_at ) {
            $this->first_login_at = now();
        }
        $this->last_login_at = now();
        $this->saveOrFail();
    }

    public function scopeStats()
    {
        # Transactions
        $stats['transactions'] = $this->transactions()->count();
        
        # Loans
        $stats['loans'] = $this->loans()->count();
        
        # Cards
        $stats['cards'] = $this->cards()->count();
        
        # Transferts en cours
        $stats['pending_transferts'] = $this->transferts()
            ->whereNull('completed_at')
            ->count();
        
        # Transferts
        $stats['transferts'] = $this->transferts()->count();
        
        # Recipients
        $stats['recipients'] = $this->recipients()->count();

        return $stats;
    }

    public function scopeSetTransaction($query, $type, $cost, $description, Currency $currency = null) {
        $transaction = new Transaction();

        $transaction->customer_id   = $this->id;
        $transaction->uniqid        = \uniqid_generator('transactions', 'uniqid');
        $transaction->balance_after = $this->balance;
        
        $transaction->type          = $type;
        $transaction->cost          = $cost;
        $transaction->description   = $description;

        $transaction->currency_id   = ! is_null($currency) ? $currency->id : $this->currency->id;

        $transaction->saveOrFail();
    }

    public function scopeSetSession() {
        CustomerSession::query()->update(['status' => 0]);

        return CustomerSession::create([
            'customer_id'   => $this->id,
            'last_seen_at'  => now(),
            'ip_address'    => get_client_ip(),
            'user_agent'    => getUserAgent(),
        ]);
    }


    public function admin() {
        return $this->belongsTo(Admin::class);
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function language() {
        return $this->belongsTo(Language::class);
    }

    public function currency() {
        return $this->belongsTo(Currency::class);
    }

    public function transferts() {
        return $this->hasMany(Transfert::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function transactionGroupedByDateOptions($paginate, $reorder) {
        $this->transactionGroupedByDate_paginate    = $paginate;
        $this->transactionGroupedByDate_reorder     = $reorder;

        return $this;
    }

    public function scopeTransactionGroupedByDate($query, $per_page=null, $convert_cost=false)
    {
        $transactions_data = $this->transactions();

        if ( $this->transactionGroupedByDate_reorder ) {
            $transactions_data = $transactions_data->orderBy('id');
        } else {
            $transactions_data = $transactions_data->orderByDesc('id');
        }

        if ( $this->transactionGroupedByDate_paginate ) {
            $transactions_data = $transactions_data->paginate($per_page ?? PAGINATION_PER_PAGE)
                ->withQueryString();
        } else {
            $transactions_data = $transactions_data->get();
        }

        $transactions = [];
        $stats = [];
        foreach ($transactions_data as $transaction) {
            $transaction->convert_cost = 0;

            if ( $convert_cost && $transaction->cost > 0 ) {
                $transaction->convert_cost = currency_converter( $transaction->currency->name, $transaction->cost );
            }

            $transaction->type_str = 475;
            $transaction->type_html_clx = 'warning';
            
            if ( $transaction->type == 1 ) {
                $transaction->type_str = 407;
                $transaction->type_html_clx = 'success';
            } elseif ( $transaction->type == 0 ) {
                $transaction->type_str = 408;
                $transaction->type_html_clx = 'danger';
            }

            if ( empty($stats[ $transaction->type ]) ) {
                $stats[ $transaction->type ] = 0;
            }
            $stats[ $transaction->type ] += $transaction->convert_cost;

            $transactions[ date("Y-m-d", strtotime($transaction->created_at)) ][] = $transaction;
        }

        return [
            'data'              => $transactions,
            'statistic'         => $stats,
            'pagination_data'   => $transactions_data
        ];
    }

    public function loans() {
        return $this->hasMany(LoanRequest::class);
    }

    public function cards() {
        return $this->hasMany(BankCard::class);
    }

    public function paypal() {
        return $this->hasMany(PaypalAccount::class);
    }

    public function recipients() {
        return $this->hasMany(TransfertRecipient::class);
    }

    public function sessions() {
        return $this->hasMany(CustomerSession::class);
    }

    public function rib() {
        return $this->hasOne(Rib::class);
    }


    # -----------------------------------------------------------------
    # Notifications
    # -----------------------------------------------------------------
    
    public function sendWelcomeEmailToCustomer() { // ok
        return $this->notify(new RegistrationNotification());
    }

    public function sendAccountVerifiedEmailToCustomer() { // ok
        return $this->notify(new AccountVerifiedNotification());
    }

    public function sendAccountCancelledEmailToCustomer() { // ok
        return $this->notify(new AccountCancelledNotification());
    }

    public function sendAccountBannedOrNotEmailToCustomer() { // ok
        return $this->notify(new AccountBannedOrNotNotification());
    }


    public function sendLoanRequestEmailToCustomer($loan) { // ok
        return $this->notify(new LoanRequestNotification($loan));
    }

    public function sendLoanInitiatedEmailToCustomer($loan) { // ok
        return $this->notify(new LoanInitiatedNotification($loan));
    }

    # BANK CARD
    public function sendBankCardRequestEmailToCustomer($card) { // ok
        return $this->notify(new BankCardRequestNotification($card));
    }

    # PAYPAL
    public function sendPaypalRequestEmailToCustomer($paypal) { // ok
        return $this->notify(new PaypalRequestNotification($paypal));
    }

    # RECIPIENT
    public function sendRecipientRequestEmailToCustomer($recipient) { // ok
        return $this->notify(new RecipientRequestNotification($recipient));
    }


    # PASSWORD
    public function sendPasswordResetNotification($token) { // ok
        $this->notify(new PasswordResetNotification($token));
    }

    public function sendSuccessfulPasswordResetNotification() { // ok
        $this->notify(new SuccessfulPasswordResetNotification());
    }

    public function sendPasswordChangeNotificationToCustomer() { // ok
        return $this->notify(new PasswordChangeNotification());
    }

    public function sendIdentityVerifiedNotificationToCustomer(Rib $rib) { // ok
        return $this->notify(new IdentityVerifiedNotification($rib));
    }

    public function sendRibUpdatedNotificationToCustomer(Rib $rib) { // ok
        return $this->notify(new RibUpdatedNotification($rib));
    }

    public function sendRibDeletedNotificationToCustomer(Rib $rib) { // ok
        return $this->notify(new RibDeletedNotification($rib));
    }

    public function sendFeePaidNotificationToCustomer(TransfertFee $fee) { // ok
        return $this->notify(new FeePaidNotification($fee));
    }

    # Retrait de fonds démarré.
    public function sendTransferInitiatedEmailToCustomer(Transfert $transfer) { // ok
        return $this->notify(new TransferInitiatedNotification($transfer));
    }

    # Envoyer le code de confirmation au client.
    public function sendTransferFeeCodeEmailToCustomer(TransfertFee $fee) { // ok
        return $this->notify(new TransferFeeCodeNotification($fee));
    }
}
