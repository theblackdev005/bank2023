<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use Illuminate\Support\Facades\Hash;

class Account extends Controller
{

    const UPLOAD_DIRECTORY = 'uploads/avatar/';


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = customer();
        return view('pages.customer.profile', compact(
            'customer'
        ));
    }

    public function timezone(Request $request)
    {
        $data = $request->validate([
            'timezone' => ['required', 'timezone'],
        ]);

        $customer = customer();

        if ( $customer->timezone !== $data['timezone'] ) {
            $customer->timezone = $data['timezone'];
            $customer->saveOrFail();
        }

        return response()->noContent();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $customer = customer();
        
        $countries = Country::active();
        $currencies = Currency::active();
        $languages = Language::active();

        return view('pages.customer.edit-account', compact(
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
    public function update(\App\Http\Requests\EditAccountRequest $request)
    {
        $customer = customer();

        try {
            # UPDATE USER AVATAR
            if ( $request->file('image') ) {
                $customer->image = self::doUpload($customer->username, 'image');
            }
            
            foreach (collect($request->validated())->forget(['password', 'image'])->toArray() as $key => $value) {
                if ( empty($value) ) {
                    continue;
                }
                $customer->$key = $value;
            }
            $customer->saveOrFail();

            # Set Transaction
            $customer->setTransaction(2, 0, 39);

        } catch (\Exception $e) {
            return back_With_Error();
        }

        # Email à l'administrateur
        $this->sendNotificationToAdmin([
            'title'     => $customer->fullname() . " - Mise à jour de profile !",
            'message'   => "Vient de mettre à jour les informations de son compte !",
        ]);

        return back_With_Success(39);
    }

    public function banishment()
    {
        $customer = customer();
        return view('pages.customer.banishment', compact(
            'customer'
        ));
    }

}
