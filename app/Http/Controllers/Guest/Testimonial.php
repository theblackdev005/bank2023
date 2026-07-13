<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Testimonial as TestimonialM;

class Testimonial extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = TestimonialM::paginate( PAGINATION_PER_PAGE )->withQueryString();
        return view('pages.guest.testimonials', compact('testimonials'));
    }

}
