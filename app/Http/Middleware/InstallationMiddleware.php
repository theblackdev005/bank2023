<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Install;

class InstallationMiddleware
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
        $notInInstallationUri = ! $request->routeIs('install.*');
        $isCompleted = false;

        try {

            if ( $notInInstallationUri && ((Install::count() <= 0) || Install::whereNull('completed_at')->exists()) ) {
                return redirect()->route('install.start', ['middleware' => 1]);
            }
            $isCompleted = ! Install::whereNull('completed_at')->exists();

        } catch (\Exception $e) {
            if ( $notInInstallationUri ) {
                return redirect()->route('install.start', ['middleware' => 2]);
            }
        }

        # Installation terminée et nous voulons atteindre la page de l'installateur
        if ( $isCompleted && !$notInInstallationUri ) {
            return abort(404);
        }

        return $next($request);
    }
}
