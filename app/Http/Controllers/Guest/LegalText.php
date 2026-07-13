<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LegalText extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $endpoint = $request->route('endpoint');

        $endpoints = legal_texts_endpoints();

        $view = 'pages.guest.legal-texts.' . $endpoint;
        if ( ! in_array($endpoint, array_keys($endpoints)) || !view()->exists($view) ) {
            return abort(404);
        }

        return view($view, compact('endpoint'));
    }
}
