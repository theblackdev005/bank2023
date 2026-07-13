<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Route;

use Closure;
use Illuminate\Http\Request;

class NoTransferMiddleware
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
        $notFoundCompletedTransfer = false;

        if ( $completed_transfert = customer_completed_transfers() ) {
            $lastPaidFee = $completed_transfert->paidFees()
                ->wherePercentage(100)
                ->first();

            if ( $lastPaidFee ) {
                $notFoundCompletedTransfer = empty(compareTimer( $lastPaidFee->load_at ));
            }
        }

        if ( $notFoundCompletedTransfer && $customer->transferts()->whereNull('completed_at')->count() <= 0 ) {
            if ( in_array(Route::currentRouteName(), ['customer.show_transfert']) ) {
                return redirectWithLocale('customer.transferts');
            }
        }

        return $next($request);
    }
}
