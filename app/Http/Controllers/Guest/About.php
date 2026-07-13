<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Testimonial;

class About extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $custom_breadcrumb = true;
        $testimonials = Testimonial::paginate(6)->withQueryString();

        return view('pages.guest.about-us', compact(
            "testimonials",
            "custom_breadcrumb"
        ));
    }
}
