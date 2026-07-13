<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BankCard as BankCardModel;

class BankCard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = admin();
        $cards = $admin->cards()
            ->orderBy('approved_at')
            ->paginate( PAGINATION_PER_PAGE )
            ->withQueryString();

        return view("pages.admin.customers.cards", compact(
            'cards'
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
            "card_id" => ["required", "exists:bank_cards,id"],
        ]) );
        $admin  = admin();

        try {
            if ( !$admin->customers()->whereId($customer_id)->exists() ) {
                return throw_exception();
            }

            $card = BankCardModel::whereId($card_id)
                ->whereCustomerId($customer_id)
                ->whereNull('approved_at')
                ->firstOrFail();

            $card->approved_at = now();
            $card->saveOrFail();

            # Set Transaction
            $card->customer->setTransaction(2, 0, 685);

            # Envoyer le mail au client
            $card->customer->sendBankCardRequestEmailToCustomer($card);
            
        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(667);
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
            "card_id" => ["required", "exists:bank_cards,id"],
        ]) );
        $admin  = admin();

        try {
            if ( !$admin->customers()->whereId($customer_id)->exists() ) {
                return throw_exception();
            }

            $card = BankCardModel::whereId($card_id)
                ->whereNull('approved_at')
                ->whereCustomerId($customer_id)
                ->firstOrFail();

            # Set Transaction
            $card->customer->setTransaction(2, 0, 686);

            # Envoyer le mail au client
            $card->customer->sendBankCardRequestEmailToCustomer($card);

            $card->delete();
            
        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(453);
    }
}
