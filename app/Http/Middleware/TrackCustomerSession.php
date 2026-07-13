<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\CustomerSession;

class TrackCustomerSession
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
        $sessid = $request->session()->get('track_session_id');
        $session = CustomerSession::whereId($sessid)
            ->whereStatus(1)
            ->first();

        if ( !$sessid || !$session ) {
            doLogout($request);

            return redirectWithLocale('guest.login');
        }

        $session->last_seen_at = now();
        $session->save();

        return $next($request);
    }
}
