<?php

namespace App\Http\Controllers\Customer;

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
        $cards = customer()->cards()
            ->orderByDesc('id')
            ->paginate( PAGINATION_PER_PAGE )
            ->withQueryString();
        return view('pages.customer.cards', compact(
            'cards'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.customer.add-cards');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\AddCardRequest $request)
    {
        $customer = customer();
        try {
            $card = new BankCardModel;

            $card->customer_id = $customer->id;
            foreach ($request->validated() as $key => $value) {
                $card->$key = $value;
            }

            # Marqué chaque nouvelle carte bancaire comme vérifiée
            if ( intval(AUTO_VERIFY_NEW_BANK_CARD) === 1 ) {
                $card->approved_at = now();
            }
            $card->saveOrFail();

            # Set Transaction
            $customer->setTransaction(2, 0, 657);

            # Email à l'administrateur
            $this->sendNotificationToAdmin([
                'title'     => $customer->fullname() . " - ajout de carte !",
                'message'   => "Vient d'ajouter une carte bancaire !",
            ]);

        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(610);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
