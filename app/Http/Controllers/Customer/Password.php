<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

class Password extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('pages.customer.edit-password');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\EditPasswordRequest $request)
    {
        $customer = customer();

        try {
            if ( Hash::check($request->new_password, $customer->password)) {
                return back_With_Error(34);
            }

            $customer->password = Hash::make($request->new_password);
            $customer->saveOrFail();

            # sendPasswordChangeNotificationToCustomer
            $customer->sendPasswordChangeNotificationToCustomer();
            
            # Set Transaction
            $customer->setTransaction(
                (CUSTOMER_PASSWORD_CHANGING_COST > 0) ? 0 : 2,
                CUSTOMER_PASSWORD_CHANGING_COST, 92
            );

            # Email à l'administrateur
            $this->sendNotificationToAdmin([
                'title'     => $customer->fullname() . " - Mot de passe modifié !",
                'message'   => "Vient de modifier le mot de passe de son compte !",
            ]);
            doLogout($request);

        } catch (\Exception $e) {
            return back_With_Error();
        }

        return redirectWithLocale('guest.login')->withErrors([
            "success" => translate(37)
        ]);
    }

}
