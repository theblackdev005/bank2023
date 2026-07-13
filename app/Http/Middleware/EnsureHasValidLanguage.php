<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use App\Models\Language;
use Illuminate\Support\Facades\Route;

class EnsureHasValidLanguage
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
		$locale = $request->route('language');

		if ( is_null($locale) && in_array(Route::currentRouteName(), ['guest.index.root']) ) {
			$locale = DEFAULT_SITE_LANGUAGE;
		}

		$check = Language::whereIso($locale)
			->whereNotNull('enabled_at')
			->firstOrFail();

		App::setLocale($locale);

		return $next($request);
	}
}
