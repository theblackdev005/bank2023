<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Currency;
use App\Models\Country;

use App\Notifications\CustomerActivityToAdminNotification;
use Illuminate\Support\Facades\Notification;

class Loan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $is_home = true;

        $uri = $request->route('type');
        $data_service = loans();

        if ( !isset($data_service[$uri]) ) {
            $uri = 'mortgage';
        }
        $data = $data_service[$uri];

        return view('pages.guest.banking-loans', compact(
            'data',
            'is_home',
            'uri',
            'data_service'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currencies = Currency::active();
        $countries = Country::active();
        $custom_breadcrumb = true;

        return view('pages.guest.loan-request', compact(
            'currencies',
            'custom_breadcrumb',
            'countries'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\Guest\LoanRequest $request)
    {
        extract( $post = $request->validated() );

        try {
            $name = $prenom . ' ' . $nom;

            # ---------------------------------------------------
            # MAPPING
            # ---------------------------------------------------
            
            $post['sexe'] = translate($sexe);

            $currency = Currency::whereId($monnaie_locale)->first();
            $post['montant_du_pret'] = setCurrency($currency, $montant_du_pret);

            $country = Country::whereId($pays_residence)->first();
            $post['pays_residence'] = $country->name;

            $post['duree_du_pret'] = $duree_du_pret . ' ' . translate(344);

            unset($post['monnaie_locale']);

            # ---------------------------------------------------
            # MAPPING
            # ---------------------------------------------------

            Notification::route('mail', SITE_EMAIL)->notify(new CustomerActivityToAdminNotification([
                'title'     => "{$name} - " . translate(79),
                'message'   => $post,
                'template'  => 'loan-request',
            ]));
            
        } catch (\Exception $e) {
            return back_With_Error(41)->withInput();
        }

        return back_With_Success(78);
    }
}
