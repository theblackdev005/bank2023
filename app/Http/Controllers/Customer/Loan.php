<?php

namespace App\Http\Controllers\Customer;

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
        $customer = customer();
        $loans = $customer->loans()
            ->orderByDesc('id')
            ->paginate(2)
            ->withQueryString();
        return view('pages.customer.loans', compact('loans', 'customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer = customer();

        return view('pages.customer.add-loans', compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\AddLoanRequest $request)
    {
        extract($post = $request->validated());
        $customer = customer();

        try {

            if ( $customer->loans()->whereNull('approved_at')->exists() ) {
                return back_With_Error(58);
            }
            
            if ( (floatval($amount) <= 0) || (intval($duration) <= 0)) {
                return back_With_Error(64);
            }
            $post['uniqid']         = \uniqid_generator('loan_requests');
            $post['customer_id']    = $customer->id;
            $post['currency_id']    = $customer->currency->id;

            $loan = LoanRequest::create($post);

            # Set Transaction
            $customer->setTransaction(1, $amount, 339);

            # Envoyer le mail au client
            $customer->sendLoanInitiatedEmailToCustomer($loan);

            # Email à l'administrateur
            $this->sendNotificationToAdmin([
                'title'     => $customer->fullname() . " - Demande de prêt !",
                'message'   => "Vient d'emettre une demande de prêt !",
            ]);

        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(62);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
