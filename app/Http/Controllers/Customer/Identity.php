<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Rib;

class Identity extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customer = customer();
        $step = $request->route('step') ?? 'index';

        if ( $customer->isVerifiedIdentity() ) {
            return abort(404);
        }

        $rib = Rib::whereCustomerId($customer->id)
            ->whereAdminId($customer->admin->id)
            ->whereNotNull('enabled_at')
            ->firstOrFail();

        $amount = setCurrency($rib->currency, $rib->amount);

        if ( ! view()->exists($view = 'pages.customer.identity-verify.' . $step) ) {
            return abort(404);
        }
        return view($view, compact('customer', 'rib', 'amount', 'step'));
    }
}
