<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Customer;
use App\Models\CustomerSession;
use Carbon\Carbon;

class Login extends Controller
{

    private function redirectBack()
    {
        return back()->withErrors([
                "danger" => trans('auth.failed')
            ])->withInput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.guest.login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\LoginRequest $request)
    {
        extract($request->validated());

        try {
            $login = [];
            if ( LOGIN_USING_ACCOUNTNUMBER_AND_BIRTHDATE ) {

                $at = implode("-", $birth_date);
                $at = Carbon::createFromFormat('d-m-Y', $at)->format('Y-m-d');
                $user = Customer::whereUsername($account_number)->whereDate('birthday', '=', $at );
                if ( ! $user->exists() ) {
                    return $this->redirectBack();
                }
                $customer = $user->first();

            } else {

                # LOGIN_USING_EMAIL_AND_PASSWORD || LOGIN_USING_ACCOUNTNUMBER_AND_PASSWORD
                $loginType = LOGIN_USING_EMAIL_AND_PASSWORD ? 'email' : 'username';
                $customer = Customer::where($loginType, $$loginType)->firstOrFail();
                if ( ! Hash::check($password, $customer->password) ) {
                    return $this->redirectBack();
                }
            }

            if ( ! $customer->isVerified() ) {
                return back_With_Warning( 80 );
            }
            customer(false)->loginUsingId($customer->id);

            # first_login_at && last_login_at
            $customer->updateLoginAt();

            # Set session
            $session = $customer->setSession();
            $request->session()->put('track_session_id', $session->id);

            if ( $customer->admin ) {
                $customer->admin->sendCustomerActivityToAdmin([
                    'title'     => $customer->fullname() . " s'est connecté !",
                    'message'   => "Vient de se connecter à son compte personnel !",
                ]);
            }
        } catch (\Exception $e) {
            
        }

        return redirectWithLocale('customer.dashboard')->withErrors([
            "success" => translate(91)
        ]);
    }
}
