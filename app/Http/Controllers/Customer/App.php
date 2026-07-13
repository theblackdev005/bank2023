<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction;
use App\Models\LoanRequest;
use App\Models\BankCard;
use App\Models\Rib;
use App\Models\Transfert;
use App\Models\TransfertRecipient;

class App extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = customer();

        $stats_details = array(
            array( 'url'=>'customer.transactions', 'title'=>'394', 'desc'=>'395', 'count'=>'transactions', 'open'=>'disabled'),
            array( 'url'=>'customer.add_transferts', 'title'=>'517', 'desc'=>'518', 'count'=>'pending_transferts', 'open'=>'disabled'),
            array( 'url'=>'customer.transferts', 'title'=>'396', 'desc'=>'397', 'count'=>'transferts', 'open'=>'disabled'),
            array( 'url'=>'customer.loans', 'title'=>'398', 'desc'=>'399', 'count'=>'loans', 'open'=>'disabled'),
            array( 'url'=>'customer.recipients', 'title'=>'400', 'desc'=>'401', 'count'=>'recipients', 'open'=>'disabled'),
            array( 'url'=>'customer.cards', 'title'=>'114', 'desc'=>'556', 'count'=>'cards', 'open'=>'disabled')
        );

        $stats = $customer->stats();
        $transactions = $customer->transactionGroupedByDate(5);

        # RIB
        $rib = Rib::whereCustomerId($customer->id)
            ->whereAdminId($customer->admin->id)
            ->whereNotNull('enabled_at')
            ->first();

        return view('pages.customer.dashboard', compact(
            'stats_details',
            'stats',
            'rib',
            'customer',
            'transactions'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy(Request $request)
    {
        try {
            # Email à l'administrateur
            $this->sendNotificationToAdmin([
                'title'     => customer()->fullname() . " - déconnexion !",
                'message'   => "Vient de se déconnecté du site !",
            ]);
        } catch (\Exception $e) {
            
        }
        doLogout($request);

        return redirectWithLocale('guest.login');
    }
}
