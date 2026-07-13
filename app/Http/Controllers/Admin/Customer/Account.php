<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Customer;
use App\Models\Country;
use App\Models\Currency;

use Illuminate\Support\Facades\Hash;

class Account extends Controller
{

    const UPLOAD_DIRECTORY = 'uploads/avatar/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $actions = ['pending', 'verified', 'banned'];

        if ( ! in_array($action = $request->route('action'), $actions) ) {
            return abort(404);
        }
        $admin      = admin();
        $languages  = Language::active();

        $customers  = $admin->customers();
        if ( $action === 'verified' ) {
            $customers  = $customers->qyVerifiedAndActif();
        } elseif ( $action === 'pending' ) {
            $customers  = Customer::whereNull('email_verified_at');
        } else {
            $customers  = $customers->qyBanned();
        }
        $customers = $customers->orderByDesc('id')
                ->paginate( PAGINATION_PER_PAGE )
                ->withQueryString();

        return view("pages.admin.customers.{$action}", compact('customers', 'languages'));
    }


    /**
     * Lock/Unlock Customer account.
     *
     * @return \Illuminate\Http\Response
     */
    public function lock()
    {
        try {
            $customer = admin_request_customer();

            if ( $customer->isBanned() ) {
                $customer->banned_at = null;
            } else {
                $customer->banned_at = now();
            }
            $customer->saveOrFail();

            # Envoyer le mail au client
            $customer->sendAccountBannedOrNotEmailToCustomer();

        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(662);
    }

    /**
     * Verify Customer account.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        try {
            $customer  = Customer::whereNull('email_verified_at')
                ->whereUsername( $request->route('username') )
                ->firstOrFail();

            # Envoyer le mail au client
            $customer->sendAccountVerifiedEmailToCustomer();

            # Valider le compte du client
            $customer->email_verified_at = now();
            $customer->password_plain_text = null;

            if ( !$customer->admin ) {
                $customer->admin_id = admin()->id;
            }

            $customer->saveOrFail();

        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(662);
    }

    /**
     * Update Customer account Balance.
     *
     * @return \Illuminate\Http\Response
     */
    public function balance(Request $request)
    {
        extract($request->validate([
            "balance"    => ["required"],
        ]));
        $username = $request->route('username');

        try {
            $customer = Customer::whereUsername($username)
                ->whereAdminId(admin()->id)->firstOrFail();

            $customer->balance = floatval($balance);
            $customer->saveOrFail();

        } catch (\Exception $e) {
            return back_With_Error(858);
        }

        return back_With_Success(670);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accountTypes   = array_map(function ($item) {
            return ['name' => translate($item), 'value' => $item];
        }, account_types());

        $genders        = array_map(function ($item) {
            return ['name' => translate($item), 'value' => $item];
        }, genders());

        $countries      = Country::active();
        $currencies     = Currency::active();
        $languages      = Language::active();

        return view("pages.admin.customers.add", compact(
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
    public function store(\App\Http\Requests\RegistrationRequest $request)
    {
        $admin = admin();
        extract( $posty = $request->validated() );

        $posty = array_merge($posty, [
            'username'  => \uniqid_generator('customers', 'username', 'account_number_generator'),
            'password'  => Hash::make($password),
            'password_plain_text'  => $password,
            'balance'   => floatval( NEW_CUSTOMER_BALANCE ),
            'admin_id'  => $admin->id,
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

        return back_With_Success(664);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $customer   = admin_request_customer();

        $countries  = Country::active();
        $currencies = Currency::active();
        $languages = Language::active();

        return view("pages.admin.customers.edit", compact(
            'customer', 'countries', 'currencies', 'languages'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\Admin\EditCustomerAccountRequest $request)
    {
        $customer = admin_request_customer();

        try {
            # UPDATE USER AVATAR
            if ( $request->file('image') ) {
                $customer->image = self::doUpload($customer->username, 'image');
            }
            
            foreach (collect($request->validated())->forget(['image'])->toArray() as $key => $value) {
                if ( empty($value) ) {
                    continue;
                }
                $customer->$key = $value;
            }
            $customer->saveOrFail();

        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(662);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $customer = admin_request_customer();

        try {
            # Envoyer le mail au client
            $customer->sendAccountCancelledEmailToCustomer();

            $customer->delete();
        } catch (\Exception $e) {
            return back_With_Error();
        }
        $endpoint = urlByCustomerStatus( $customer );

        return redirectWithLocale('admin.customers', $endpoint)->withErrors([
            "success" => translate(662)
        ]);
    }
}
