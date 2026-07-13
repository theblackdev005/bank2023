<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Notification;
use App\Notifications\ContactNotification;
use App\Models\Contact as ContactModel;
use App\Models\Customer;
use App\Models\Admin;

class Contact extends Controller
{

    private static function set_contact(array $post, $status)
    {
        $contact = new ContactModel();
        foreach ($post as $key => $value) {
            $contact->$key = $value;
        }
        $contact->status = $status;
        $contact->save();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.guest.contact-us', [
            'is_home' => true,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\ContactRequest $request)
    {
        extract( $contacts = $request->validated() );

        # VERIFIER SI C'EST UN CLIENT APPARTENANT A UN ADMIN
        $customer                   = Customer::whereEmail($email)->first();
        $notifyEmailAddr            = SITE_EMAIL;

        $admin = false;
        if ( $customer && $customer->admin ) {
            $admin = $customer->admin;
        } elseif ( !empty($account_manager) ) {
            $admin = Admin::whereId($account_manager)->first();
        }

        if ( $admin ) {
            $notifyEmailAddr        = $admin->email;
            $contacts['admin_id']   = $admin->id;
        }
        unset($contacts['account_manager']);

        try {
            Notification::route('mail', $notifyEmailAddr)->notify(new ContactNotification([
                'subject'   => $subject,
                'message'   => $contacts,
            ]));
            self::set_contact($contacts, 'success');

        } catch (\Exception $e) {
            self::set_contact($contacts, 'failed');

            return back_With_Error()->withInput();
        }

        return back_With_Success(78);
    }

}
