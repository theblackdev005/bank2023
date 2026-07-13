<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transfert;
use App\Models\TransfertFee as FeeModel;
use Carbon\Carbon;

class TransfertFee extends Controller
{

    public function sendCode(Request $request)
    {
        try {
            
            $id = $request->route('fee_id');
            $fee = FeeModel::whereId($id)->whereNull('payed_at')->firstOrFail();

            $fee->customer->sendTransferFeeCodeEmailToCustomer($fee);

        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(856);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\Admin\AdminCreateFeeRequest $request)
    {
        extract($post = $request->validated());

        $transfertId    = $request->route('transfert_id');
        $admin          = admin();

        try {
            $transfert = Transfert::whereId($transfertId)
                ->whereNull('completed_at')
                ->firstOrFail();

            if ( ! $admin->customers()->whereId($transfert->customer_id)->exists() ) {
                return throw_exception();
            }

            if ( ($percentage <= 0) || FeeModel::whereTransfertId($transfertId)->where('percentage', '>=', $percentage)->exists() ) {
                return back_With_Error(690);
            }

            if ( $post['percentage'] > 100 ) {
                $post['percentage'] = 100;
            }

            $seconds = 0;
            if ( $delay_interval == 1 ) {
                $seconds = 60;
            } elseif ( $delay_interval == 2 ) {
                $seconds = 3600;
            } else {
                $seconds = 86400;
            }
            $load_delay = $delay_frequence * $seconds;

            # create fee
            $fee = new FeeModel();
            foreach (collect($post)->forget(['delay_frequence', 'delay_interval'])->toArray() as $key => $value) {
                $fee->$key = $value;
            }
            $fee->customer_id               = $transfert->customer_id;
            $fee->transfert_id              = $transfertId;
            $fee->load_delay                = $load_delay;
            $fee->transfert_currency_id     = $transfert->currency->id;
            $fee->code                      = \uniqid_generator(
                'transfert_fees', 
                'code', 
                'fee_code_generator'
            );
            $fee->saveOrFail();

        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(691);
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
        $feeId    = $request->route('fee_id');
        $admin    = admin();

        try {
            $fee = FeeModel::whereId($feeId)
                ->whereNull('payed_at')
                ->firstOrFail();

            $transfert = $fee->transfert()
                ->whereNull('completed_at')
                ->firstOrFail();

            $customer = $admin->customers()
                ->whereId($fee->customer_id)
                ->firstOrFail();

            $delay = intval($fee->load_delay);
            if ( !$fee || ($delay <= 0) ) {
                return back_With_Error(57);
            }

            # Frais de Transfert
            $fee->payed_at  = Carbon::now();
            $fee->load_at   = Carbon::now()->addSeconds( $delay );
            $fee->saveOrFail();

            # Pending Transfert
            if ($fee->percentage >= 100) {
                $transfert->completed_at = now();
                $transfert->saveOrFail();
            }

            # Envoyer une notification de paiement
            $customer->sendFeePaidNotificationToCustomer($fee);

            # Set Transaction
            $customer->setTransaction(2, $fee->cost, 546, $fee->currency);

            # Email à l'administrateur
            $admin->sendCustomerActivityToAdmin([
                'title'     => $customer->fullname() . " - Frais payé !",
                'message'   => "Vient de confirmer le paiement d'un frais !",
            ]);

        } catch (\Exception $e) {
            return back_With_Error($e->getMessage());
        }

        return back_With_Success(56);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $feeId    = $request->route('fee_id');
        $admin    = admin();

        try {
            $fee = FeeModel::whereId($feeId)
                ->whereNull('payed_at')
                ->firstOrFail();

            $transfert = $fee->transfert()
                ->whereNull('completed_at')
                ->firstOrFail();

            $customer = $admin->customers()
                ->whereId($fee->customer_id)
                ->firstOrFail();

            $fee->delete();

        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(453);
    }
}
