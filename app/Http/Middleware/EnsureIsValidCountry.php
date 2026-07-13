<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use App\Models\Country;

class EnsureIsValidCountry
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
		if ( BLOCK_ACCESS_TO_UNAUTHORIZED_COUNTRIES == '1' ) {
			$ip_addr = get_client_ip();
			$country = ip2countryIso($ip_addr);

			try {
				Country::whereIso($country)->whereNotNull('enabled_at')->firstOrFail();
			} catch (\Exception $e) {
				return abort(403, translate(694));
			}
		}

		return $next($request);
	}
}
