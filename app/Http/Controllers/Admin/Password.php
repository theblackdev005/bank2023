<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

class Password extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('pages.admin.password');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\Admin\EditAdminPasswordRequest $request)
    {
        $admin = admin();

        try {
            if ( Hash::check($request->new_password, $admin->password)) {
                return back()->withErrors([
                    "danger" => translate(34)
                ]);
            }

            $admin->password = Hash::make($request->new_password);
            $admin->saveOrFail();

        } catch (\Exception $e) {
            return back_With_Error();
        }
        doLogout($request, true);

        return redirectWithLocale('admin.login')->withErrors([
            "success" => translate(37)
        ]);
    }
}
