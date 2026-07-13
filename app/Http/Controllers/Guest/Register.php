<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Customer;

use App\Http\Requests\RegistrationRequest;
use Illuminate\Support\Facades\Hash;

use App\Notifications\CustomerActivityToAdminNotification;
use Illuminate\Support\Facades\Notification;

class Register extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accountTypes = array_map(function ($item) {
            return ['name' => translate($item), 'value' => $item];
        }, account_types());

        $genders = array_map(function ($item) {
            return ['name' => translate($item), 'value' => $item];
        }, genders());

        $countries = Country::active();
        $currencies = Currency::active();
        $languages = Language::active();

        return view('pages.guest.register', compact(
            'accountTypes',
            'genders', 
            'countries',
            'languages',
            'currencies'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegistrationRequest $request)
    {
        extract( $posty = $request->validated() );

        $posty = array_merge($posty, [
            'username'      => \uniqid_generator('customers', 'username', 'account_number_generator'),
            'password'      => Hash::make($password),
            'balance'       => floatval( NEW_CUSTOMER_BALANCE ),
        ]);

        # Save user to database
        $customer = new Customer();
        foreach ($posty as $key => $value) {
            $customer->$key = $value;
        }
        $customer->saveOrFail();

        # Save customer transaction to database
        $customer->setTransaction(1, NEW_CUSTOMER_BALANCE, 65);

        # Email au client
        $customer->sendWelcomeEmailToCustomer();

        # Email à l'administrateur
        Notification::route('mail', SITE_EMAIL)->notify(new CustomerActivityToAdminNotification([
            'title'     => $customer->fullname() . " s'est inscrit !",
            'message'   => "Vient de faire son inscription sur le site !",
        ]));

        return back_With_Success(80);
    }
}
