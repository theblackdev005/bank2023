<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Insurance extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $uri = $request->route('type');
        $data_service = insurances();

        if ( !isset($data_service[$uri]) ) {
            $uri = 'loan';
        }
        $data = $data_service[$uri];

        return view('pages.guest.loans-insurances', compact(
            'data_service',
            'data',
            'uri'
        ));
    }
}
