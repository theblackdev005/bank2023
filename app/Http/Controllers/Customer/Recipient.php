<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\Currency;
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
        $recipients   = customer()->recipients()
            ->paginate( PAGINATION_PER_PAGE )
            ->withQueryString();

        return view('pages.customer.recipients', compact(
            'recipients'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currencies = Currency::active();
        $countries = Country::active();

        return view('pages.customer.add-recipients', compact(
            'currencies',
            'countries',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\AddRecipientRequest $request)
    {
        $customer = customer();

        try {
            $post = $request->validated();
            $post['customer_id'] = $customer->id;

            $recipient = new TransfertRecipient();
            foreach ($post as $key => $value) {
                $recipient->$key = $value;
            }

            # Marqué chaque nouveau compte bénéficiaire comme vérifié
            if ( intval(AUTO_VERIFY_NEW_RECIPIENT_ACCOUNT) === 1 ) {
                $recipient->approved_at = now();
            }

            $recipient->saveOrFail();
            
        } catch (\Exception $e) {
            return back_With_Error();
        }

        # Set Transaction
        $customer->setTransaction(
            (CUSTOMER_RECIPIENT_ADDING_COST > 0) ? 0 : 2, 
            CUSTOMER_RECIPIENT_ADDING_COST, 93
        );

        # Email à l'administrateur
        $this->sendNotificationToAdmin([
            'title'     => $customer->fullname() . " - ajout de bénéficiaire !",
            'message'   => "Vient d'ajouter un nouveau compte bénéficiaire !",
        ]);

        return back_With_Success(48);
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
