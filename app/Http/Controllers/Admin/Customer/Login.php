<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Login extends Controller
{
    
    public function switch(Request $request)
    {
        if ( ! admin(false)->check() ) {
            return abort(403);
        }
        $customer = admin_request_customer();

        if ( ! $customer->isVerified() ) {
            return back_With_Warning( 80 );
        }
        admin(false)->logout();
        customer(false)->loginUsingId($customer->id);

        # Set session
        $session = $customer->setSession();
        $request->session()->put('track_session_id', $session->id);

        return redirectWithLocale('customer.dashboard')->withErrors([
            "info" => 'Vous êtes connecté en tant que client !'
        ]);
    }
}
