<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Install;
use Illuminate\Support\Facades\File;

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
        $installedLock = storage_path('app/installed.lock');
        $notInInstallationUri = ! $request->routeIs('install.*');
        $isCompleted = false;

        if (file_exists($installedLock)) {
            if (! $notInInstallationUri) {
                return abort(404);
            }

            return $next($request);
        }

        try {
            $installCount = Install::count();
            $hasIncompleteStep = Install::whereNull('completed_at')->exists();

            if ( $notInInstallationUri && (($installCount <= 0) || $hasIncompleteStep) ) {
                return redirect()->route('install.start', ['middleware' => 1]);
            }
            $isCompleted = $installCount > 0 && ! $hasIncompleteStep;

        } catch (\Exception $e) {
            if ( $notInInstallationUri ) {
                return redirect()->route('install.start', ['middleware' => 2]);
            }
        }

        if ($isCompleted && ! file_exists($installedLock)) {
            try {
                $directory = dirname($installedLock);
                File::ensureDirectoryExists($directory, 0755, true);

                if (is_writable($directory)) {
                    File::put($installedLock, now()->toDateTimeString());
                }
            } catch (\Throwable $e) {
                report($e);
            }
        }

        # Installation terminée et nous voulons atteindre la page de l'installateur
        if ( $isCompleted && !$notInInstallationUri ) {
            return abort(404);
        }

        return $next($request);
    }
}
