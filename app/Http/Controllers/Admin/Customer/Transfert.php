<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transfert as TransfertModel;

class Transfert extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = admin_request_customer();
        $transferts = $customer->transferts()
            ->orderByDesc('id')
            ->paginate( 3 )
            ->withQueryString();

        return view("pages.admin.customers.transferts", compact(
            'transferts', 'customer'
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
        $admin  = admin();

        $transfertId = $request->route('id');
        $customer = admin_request_customer();

        try {
            if ( !$admin->customers()->whereId($customer->id)->exists() ) {
                return throw_exception();
            }
            $transfert = TransfertModel::whereId($transfertId)
                ->whereCustomerId( $customer->id )
                ->firstOrFail();

            # Supprimer les frais
            $transfert->fees()->delete();

            # Supprimer le transfert
            $transfert->delete();

        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(453);
    }
}
