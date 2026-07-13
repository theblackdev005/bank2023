<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GoogleRecaptcha
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
        if ( GOOGLE_RECAPTCHA_ENABLED ) {

            $client = new Client;
            $response = $client->post(
                'https://www.google.com/recaptcha/api/siteverify',
                [
                    'form_params' =>
                        [
                            'secret' => GOOGLE_RECAPTCHA_SECRET,
                            'response' => $request->get('g-recaptcha-response')
                        ]
                ]
            );
            $body = json_decode((string)$response->getBody());

            if ( ! $body->success ) {
                return back_With_Error(729)->withInput();
            }
        }

        return $next($request);
    }
}
