<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomerUnverifiedMiddleware
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

        if ( $isInactif = !$customer->isVerified() ) {
            doLogout($request);

            return redirectWithLocale('guest.login')->withErrors([
                'danger' => translate( 538 )
            ]);
        }

        return $next($request);
    }
}
