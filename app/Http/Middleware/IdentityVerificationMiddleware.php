<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Route;

use Closure;
use Illuminate\Http\Request;

class IdentityVerificationMiddleware
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
        $customer   = customer();
        $rib        = $customer->rib()->whereNotNull('enabled_at')->first();
        $route      = Route::currentRouteName();

        if ( $customer->isVerifiedIdentity() ) {
            if ( in_array($route, ['customer.identity_verification']) ) {
                return redirect( routeWithLocale('customer.dashboard') );
            }
        }

        if ( !$customer->isVerifiedIdentity() && $rib && ($rib->amount > 0) ) {
            if ( !in_array($route, ['customer.identity_verification', 'customer.banned', 'customer.logout']) ) {
                return redirect( routeWithLocale('customer.identity_verification') );
            }
        } else {
            if ( in_array($route, ['customer.identity_verification']) ) {
                return redirect( routeWithLocale('customer.dashboard') );
            }
        }

        return $next($request);
    }
}
