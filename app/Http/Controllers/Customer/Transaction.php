<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Currency;

class Transaction extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer       = customer();
        $transactions   = $customer->transactionGroupedByDate();

        return view('pages.customer.transactions', compact(
            'transactions',
            'customer'
        ));
    }


    /**
     * download resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download()
    {
        $customer       = customer();

        $DEFAULT_CURRENCY = Currency::whereName( DEFAULT_CONVERT_CURRENCY )->firstOrFail();

        try {
            $reference = rand(10000, 99999);
            $transactions = $customer->transactionGroupedByDateOptions(false, true)
                ->transactionGroupedByDate(null, true);

            $totalDebit         = setCurrency($DEFAULT_CURRENCY, floatval(@$transactions['statistic'][0]));
            $totalCredit        = setCurrency($DEFAULT_CURRENCY, floatval(@$transactions['statistic'][1]));
            $totalFacturation   = setCurrency($DEFAULT_CURRENCY, floatval(@$transactions['statistic'][2]));

            $html2PdfHTML = view('pdfs.transactions', compact(
                'reference', 'transactions', 'customer',
                'totalDebit', 'totalCredit', 'totalFacturation',
                'DEFAULT_CURRENCY'
            ));
            generate_pdf($html2PdfHTML, $reference);
            
        } catch (\Exception $e) {
            return back_With_Error();
        }
    }
}
