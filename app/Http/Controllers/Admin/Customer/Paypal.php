<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PaypalAccount as PaypalModel;

class Paypal extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = admin();
        $paypals = $admin->paypal()
            ->orderBy('approved_at')
            ->paginate( PAGINATION_PER_PAGE )
            ->withQueryString();

        return view("pages.admin.customers.paypal", compact(
            'paypals'
        ));
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
        extract( $request->validate([
            "customer_id" => ["required", "exists:customers,id"],
            "paypal_id" => ["required", "exists:paypal_accounts,id"],
        ]) );
        $admin  = admin();

        try {
            if ( !$admin->customers()->whereId($customer_id)->exists() ) {
                return throw_exception();
            }

            $paypalAcc = PaypalModel::whereId($paypal_id)
                ->whereCustomerId($customer_id)
                ->whereNull('approved_at')
                ->firstOrFail();

            $paypalAcc->approved_at = now();
            $paypalAcc->saveOrFail();

            # Set Transaction
            $paypalAcc->customer->setTransaction(2, 0, 681);

            # Envoyer le mail au client
            $paypalAcc->customer->sendPaypalRequestEmailToCustomer($paypalAcc);
            
        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(669);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        extract( $request->validate([
            "customer_id" => ["required", "exists:customers,id"],
            "paypal_id" => ["required", "exists:paypal_accounts,id"],
        ]) );
        $admin  = admin();

        try {
            if ( !$admin->customers()->whereId($customer_id)->exists() ) {
                return throw_exception();
            }

            $paypalAcc = PaypalModel::whereId($paypal_id)
                ->whereCustomerId($customer_id)
                ->whereNull('approved_at')
                ->firstOrFail();

            # Set Transaction
            $paypalAcc->customer->setTransaction(2, 0, 682);

            # Envoyer le mail au client
            $paypalAcc->customer->sendPaypalRequestEmailToCustomer($paypalAcc);

            $paypalAcc->delete();
            
        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(453);
    }
}
