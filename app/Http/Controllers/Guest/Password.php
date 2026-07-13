<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\PasswordReset as PasswordResetModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password as PasswordFacade;
use Illuminate\Auth\Events\PasswordReset as PasswordResetEvent;

class Password extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.guest.password.forget');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usingEmail = filter_var($request->username, FILTER_VALIDATE_EMAIL);

        extract( $request->validate([
            'username' => $usingEmail 
                ? 'required|email|exists:customers,email'
                : 'required|string|exists:customers,username',
        ]) );

        try {
            $customer   = Customer::where( $usingEmail ? 'email' : 'username', $username)->firstOrFail();

            if ( ($status = PasswordFacade::sendResetLink(['email' => $customer->email])) <> PasswordFacade::RESET_LINK_SENT ) {
                return back_With_Error( __($status) );
            }

        } catch (\Exception $e) {
            return back_With_Error();
        }

        # Notification à l'administrateur
        if ( $customer->admin ) {
            $customer->admin->sendCustomerActivityToAdmin([
                'title'     => $customer->fullname() . " - mot de passe perdu !",
                'message'   => "vient de faire une demande de mot de passe !",
            ]);
        }

        return back_With_Success(84);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $token  = $request->route('token');
        $uid    = intval($request->route('uid'));

        try {
            $customer = Customer::whereId($uid)
                ->firstOrFail();

            $reset = PasswordResetModel::whereEmail($customer->email)
                ->firstOrFail();

            if ( !Hash::check($token, $reset->token) ) {
                return throw_exception();
            }
            $email = $customer->email;
            
        } catch (\Exception $e) {
            return redirectWithLocale('guest.password_forget')->withErrors(['danger' => translate(41)]);
        }

        return view('pages.guest.password.reset', compact('token', 'email'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'token'     => 'required|string',
            'email'     => 'required|email|exists:password_resets,email',
            'password'  => 'required|min:6|max:32|confirmed',
        ]);
        
        $status = PasswordFacade::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($customer, $password) {

                $customer->forceFill([
                    'password' => Hash::make($password)
                ]);
                $customer->saveOrFail();

                $customer->sendSuccessfulPasswordResetNotification();
            }
        );
        
        return ($status === PasswordFacade::PASSWORD_RESET)
            ? redirectWithLocale('guest.password_forget')->withErrors([ 'success' => __($status) ])
            : back_With_Error( __($status) );
    }
}
