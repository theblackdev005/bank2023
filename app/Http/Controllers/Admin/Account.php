<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class Account extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::orderByDesc('super_admin')->paginate( PAGINATION_PER_PAGE )
            ->withQueryString();
        $adminCount = Admin::count();

        return view('pages.admin.listing', compact('admins', 'adminCount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\Admin\AdminCreatingRequest $request)
    {
        extract($request->validated());

        try {
            
            $admin              = new Admin();
            $admin->name        = $name;
            $admin->username    = $username;
            $admin->email       = $email;
            $admin->password    = Hash::make($password);
            $admin->super_admin = strval( intval($request->filled('enable')) );
            $admin->saveOrFail();

            $admin->sendAdminWelcomeEmail(compact('name', 'username', 'email', 'password'));

        } catch (\Exception $e) {
            return back_With_Error($e->getMessage());
        }

        return back_With_Success(692);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $admin = admin();

        return view('pages.admin.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $admin = admin();

        extract( $request->validate([
            "email" => ["required", "email", "unique:admins,email," . $admin->id . ",id"],
            "name" => ["required", "string", "unique:admins,name," . $admin->id . ",id"],
        ]) );

        try {
            # Envoyer le mail avant de faire les modifications
            $admin->sendCustomerActivityToAdmin([
                'title'     => SITE_NAME . ' - ' . translate(39),
                'message'   => translate(828),
            ]);

            $admin->name = $name;
            $admin->email = $email;
            $admin->saveOrFail();

        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(39);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\App\Http\Requests\Admin\AdminDeletingRequest $request)
    {
        extract($request->validated());

        try {
            $targetedAdmin = Admin::whereId($admin_id)->firstOrFail();
            if ( $targetedAdmin->isSuper() ) {
                return back_With_Error(693);
            }

            $customers = $targetedAdmin->customers();
            if ( $customers->count() > 0 ) {
                $customers->update(['admin_id' => admin()->id]);
            }

            $targetedAdmin->delete();

        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(453);
    }
}
