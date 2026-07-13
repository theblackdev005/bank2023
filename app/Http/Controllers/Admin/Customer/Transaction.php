<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Transaction extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = admin_request_customer();
        $transactions = $customer->transactionGroupedByDate();

        return view("pages.admin.customers.transactions", compact(
            'transactions', 'customer'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            
            $customer = admin_request_customer();

            $transaction = $customer->transactions()
                ->whereUniqid( $request->route('uniqid') )
                ->firstOrFail();
            $transaction->delete();

        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(453);
    }
}
