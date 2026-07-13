<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\Testimonial as TestimonialM;

class Testimonial extends Controller
{

    const UPLOAD_DIRECTORY = 'uploads/testimonials/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = admin();
        $testimonials = $admin->testimonials()
            ->paginate( PAGINATION_PER_PAGE )
            ->withQueryString();
        $countries = Country::active();

        return view('pages.admin.testimonials', compact('testimonials', 'countries', 'admin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\Admin\AdminCreateTestimonialRequest $request)
    {
        $admin = admin();

        try {
            $uniqid = \uniqid_generator('testimonials');

            $testimonial            = new TestimonialM();
            $testimonial->uniqid    = $uniqid;
            foreach ($request->validated() as $key => $value) {
                $testimonial->$key  = $value;
            }
            $testimonial->image     = self::doUpload($uniqid, 'image');
            $testimonial->admin_id  = $admin->id;
            $testimonial->saveOrFail();

        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(665);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $admin = admin();
        $testimonial_id = $request->route('id');

        try {
            $testimonial = $admin->testimonials()
                ->whereId($testimonial_id)
                ->firstOrFail();

            $testimonial->delete();

        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(665);
    }
}
