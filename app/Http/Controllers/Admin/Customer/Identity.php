<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Rib;

class Identity extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rib_id = $request->route('rib_id');
        $admin = admin();

        try {
            $rib = Rib::whereId($rib_id)->whereAdminId($admin->id)->firstOrFail();

            $customer = $rib->customer;

            $customer->identity_verified_at = now();
            $customer->balance += $rib->amount;
            $customer->saveOrFail();

            $customer->sendIdentityVerifiedNotificationToCustomer($rib);

        } catch (\Exception $e) {
            return back_With_Error($e->getMessage());
        }

        return back_With_Success(781);
    }

}
