<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\LoanRequest;

class Loan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = admin();
        $loans = $admin->loans()
            ->whereNull('approved_at')
            ->orderByDesc('id')
            ->paginate( PAGINATION_PER_PAGE )
            ->withQueryString();
        $customers = $admin->customers()->get();

        return view("pages.admin.customers.pending-loans", compact(
            'loans',
            'customers'
        ));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        extract( $post = $request->validate([
            "customer_id" => ["required", "exists:customers,id"],

            "amount" => ["required"],
            "duration" => ["required"],
            "goal" => ["required"],
        ]) );
        $admin  = admin();

        try {
            if ( !$customer = $admin->customers()->whereId($customer_id)->first() ) {
                return throw_exception();
            }

            if ( (floatval($amount) <= 0) || (intval($duration) <= 0)) {
                return back_With_Error(64);
            }
            $post['uniqid'] = \uniqid_generator('loan_requests');
            $post['currency_id'] = $customer->currency->id;

            # Add Loan Request
            $loan = LoanRequest::create($post);

            # Set Transaction
            $loan->customer->setTransaction(1, $amount, 339);

            # Envoyer le mail au client
            $loan->customer->sendLoanInitiatedEmailToCustomer($loan);
            
        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(62);
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
        extract( $post = $request->validate([
            "accept_loan_id" => ["required", "exists:loan_requests,id"],
            "customer_id" => ["required", "exists:customers,id"],

            "teag" => ["required"],
            "start_at" => ["required"],
            "total_interest" => ["required"],
            "monthly_payment" => ["required"],
            "total_mpayment" => ["required"],
        ]) );
        $admin  = admin();

        try {
            if ( !$admin->customers()->whereId($customer_id)->exists() ) {
                return throw_exception();
            }

            $loan = LoanRequest::whereId($accept_loan_id)
                ->whereCustomerId($customer_id)
                ->whereNull('approved_at')
                ->firstOrFail();

            foreach (collect($post)->forget(['accept_loan_id', 'customer_id'])->toArray() as $key => $value) {
                $loan->$key = $value;
            }
            $loan->approved_at = now();
            $loan->saveOrFail();

            # Modifier le solde
            $loan->customer->balance += $loan->amount;
            $loan->customer->saveOrFail();

            # Set Transaction
            $loan->customer->setTransaction(1, $loan->amount, 454, $loan->currency);

            # Envoyer le mail au client
            $loan->customer->sendLoanRequestEmailToCustomer($loan);
            
        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(668);
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
            "loan_id" => ["required", "exists:loan_requests,id"],
        ]) );
        $admin  = admin();

        try {
            if ( !$admin->customers()->whereId($customer_id)->exists() ) {
                return throw_exception();
            }

            $loan = LoanRequest::whereId($loan_id)
                ->whereCustomerId($customer_id)
                ->firstOrFail();

            # Set Transaction
            $loan->customer->setTransaction(2, 0, 680, $loan->currency);

            # Envoyer le mail au client
            $loan->customer->sendLoanRequestEmailToCustomer($loan);

            $loan->delete();
            
        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(453);
    }
}
