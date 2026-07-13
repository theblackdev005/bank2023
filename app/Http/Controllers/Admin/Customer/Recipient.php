<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TransfertRecipient;

class Recipient extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = admin();
        $recipients = $admin->recipients()
            ->orderBy('approved_at')
            ->paginate( PAGINATION_PER_PAGE )
            ->withQueryString();

        return view("pages.admin.customers.recipients", compact(
            'recipients'
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
            "recipient_id" => ["required", "exists:transfert_recipients,id"],
        ]) );
        $admin  = admin();

        try {
            if ( !$admin->customers()->whereId($customer_id)->exists() ) {
                return throw_exception();
            }

            $recipient = TransfertRecipient::whereId($recipient_id)
                ->whereCustomerId($customer_id)
                ->whereNull('approved_at')
                ->firstOrFail();

            $recipient->approved_at = now();
            $recipient->saveOrFail();

            # Set Transaction
            $recipient->customer->setTransaction(2, 0, 683);

            # Envoyer le mail au client
            $recipient->customer->sendRecipientRequestEmailToCustomer($recipient);
            
        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(671);
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
            "recipient_id" => ["required", "exists:transfert_recipients,id"],
        ]) );
        $admin  = admin();

        try {
            if ( !$admin->customers()->whereId($customer_id)->exists() ) {
                return throw_exception();
            }

            $recipient = TransfertRecipient::whereId($recipient_id)
                ->whereNull('approved_at')
                ->whereCustomerId($customer_id)
                ->firstOrFail();

            # Set Transaction
            $recipient->customer->setTransaction(2, 0, 684);

            # Envoyer le mail au client
            $recipient->customer->sendRecipientRequestEmailToCustomer($recipient);

            $recipient->delete();
            
        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(453);
    }
}
