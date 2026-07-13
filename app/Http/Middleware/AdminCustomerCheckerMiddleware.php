<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminCustomerCheckerMiddleware
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
        $customer = admin()->customers()
            ->whereUsername( $request->route('username') )
            ->firstOrFail();
        $request->request->add([ADMIN_MIDDLEWARE_CUSTOMER_KEY => $customer]);

        return $next($request);
    }
}
