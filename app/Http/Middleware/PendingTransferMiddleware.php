<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Route;

use Closure;
use Illuminate\Http\Request;

class PendingTransferMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $customer = customer();
        $check = false;

        if ( BLOCK_CUSTOMER_ON_TRANSFER_PAGE ) {

            if ( $completed_transfert = customer_completed_transfers() ) {
                $lastPaidFee = $completed_transfert->paidFees()
                    ->wherePercentage(100)
                    ->first();

                if ($lastPaidFee) {
                    $check = ! empty(compareTimer( $lastPaidFee->load_at ));
                }
            }

            if ( ! $check ) {
                $check = $customer->transferts()
                    ->whereNull('completed_at')
                    ->exists();
            }

            if ( $check && !in_array(Route::currentRouteName(), [
                'customer.dashboard',
                'customer.sessions',
                'customer.download_transferts',
                'customer.download_transactions',
                'customer.identity_verification',
                'customer.banned',
                'customer.show_transfert',

                'customer.account',
                'customer.edit_account',
                'customer.edit_account.post',
                'customer.edit_password',
                'customer.edit_password.post',

                'customer.logout'
            ]) ) {
                return redirect( routeWithLocale('customer.show_transfert') );
            }
        }

        return $next($request);
    }
}
