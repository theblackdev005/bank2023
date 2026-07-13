<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class Login extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ( !in_array($request->route('page'), [null, 'login']) ) {
            return abort(404);
        }
        return view('pages.admin.login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\Admin\LoginRequest $request)
    {
        if ( !in_array($request->route('page'), [null, 'login']) ) {
            return abort(404);
        }
        
        extract($request->validated());

        try {
            $admin = Admin::whereUsername($username)->first();
            if ( ! Hash::check($password, $admin->password) ) {
                throw new \Exception(trans('auth.failed'));
            }
            admin(false)->loginUsingId($admin->id);

        } catch (\Exception $e) {
            return back()->withErrors([
                    "danger" => $e->getMessage()
                ])->withInput();
        }

        return redirectWithLocale('admin.dashboard')->withErrors([
            "success" => translate(91)
        ]);
    }
}
