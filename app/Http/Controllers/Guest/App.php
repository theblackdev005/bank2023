<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Testimonial;

class App extends Controller
{

    public function index()
    {
        $is_home = true;
        $testimonials = Testimonial::limit(3)->get();

        $slides = array(
            'slider_1' => [
                'title' => 285,
                'text' => 291,
                'btnText' => 134,
                'btnLink' => 'guest.register',
                'image' => 'slides/slider_1.png',
            ],
            'slider_2' => [
                'title' => 537,
                'text' => 314,
                'btnText' => 132,
                'btnLink' => 'guest.login',
                'image' => 'slides/slider_2.png',
            ],
        );

        $solutions = array(
            'guest.contact' => [
                'title' => 562,
                'text' => 563,
                'icon' => 'card_travel',
                'theme' => 'warning',
            ],
            'guest.security' => [
                'title' => 564,
                'text' => 565,
                'icon' => 'security',
                'theme' => 'theme',
            ],
            'guest.login' => [
                'title' => 566,
                'text' => 567,
                'icon' => 'family_restroom',
                'theme' => 'theme',
            ],
            'guest.loans' => [
                'title' => 120,
                'text' => 761,
                'icon' => 'real_estate_agent',
                'theme' => 'danger',
            ],
            
        );

        return view('pages.guest.index', compact(
            "testimonials",
            "solutions",
            "slides",
            "is_home"
        ));
    }

    // public function bank_accounts() {
    //     return view('pages.guest.bank-accounts');
    // }

    // public function partners() {
    //     return view('pages.guest.partners');
    // }

}
