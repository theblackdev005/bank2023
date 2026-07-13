<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;

use Illuminate\Support\Facades\Notification;
use App\Notifications\ContactNotification;

class ContactForm extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = self::get_contact()
            ->paginate( PAGINATION_PER_PAGE )
            ->withQueryString();

        return view('pages.admin.customers.contact-form', compact(
            'contacts'
        ));
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
            'contactId' => ["required", "exists:contacts,id"]
        ]) );

        try {
            $contact = self::get_contact()
                ->whereId($contactId)
                ->firstOrFail();

            Notification::route('mail', $admin->email)->notify(new ContactNotification([
                'subject'               => $contact->subject,
                'hideCustomerInfo'      => true,
                'message'               => $contact->toArray(),
            ]));

            $contact->status = 'success';
            $contact->saveOrFail();

        } catch (\Exception $e) {
            return back_With_Error();
        }
        return back_With_Success(78);
    }
}
