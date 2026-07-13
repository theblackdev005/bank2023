<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CustomerBannedMiddleware
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

        if ( $customer->isBanned() ) {
            if ( !in_array(Route::currentRouteName(), ['customer.banned', 'customer.logout']) ) {
                return redirect( routeWithLocale('customer.banned') );
            }
        } else {
            if ( in_array(Route::currentRouteName(), ['customer.banned']) ) {
                return redirect( routeWithLocale('customer.dashboard') );
            }
        }

        return $next($request);
    }
}
