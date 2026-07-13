<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SmsHistory;
use Smsplateform\Client\Auth;
use Smsplateform\Client\Request as SpRequest;

class Sms extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = admin();
        
        $sms = $admin->sms()
            ->orderByDesc('id')
            ->paginate( PAGINATION_PER_PAGE )
            ->withQueryString();
        $customers = $admin->customers()->get();

        $sms_api_config = $admin->smsApi()->first();

        return view("pages.admin.customers.sms", compact(
            'sms',
            'sms_api_config',
            'customers'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        extract( $request->validate([
            "customer_id" => ["required", "exists:customers,id"],
            "message" => ["required", "string"],
        ]) );
        $admin  = admin();

        try {
            $uniqid = \uniqid_generator('sms_histories');

            $customer = $admin->customers()->whereId($customer_id);
            if ( !$customer->exists() ) {
                return throw_exception();
            }
            $customer = $customer->first();

            $credentials = $admin->smsApi()->whereNotNull('enabled_at')->first();
            if ( !$credentials ) {
                return back_With_Error(442);
            }
            $phone_number = \sanitizePhoneNumber($customer->phone_number);

            Auth::Init( $credentials->username, $credentials->password );
            $sms = new SpRequest([
                "sender"        => $credentials->sender,
                "msisdn"        => $phone_number,
                "message"       => $message,
                'webhook_url'   => routeWithLocale('admin.sms_webhook.post', $uniqid)
            ]);
            $result = $sms->Send();
            $data = $result->getResponse();


            if ( empty($data['results']) ) {
                if ( !empty($data['errors']['message']) ) {
                    return back_With_Error( $data['errors']['message'] );
                }
                return back_With_Error(672);
            }

            # Insérer les informations dans la base de données.
            $smsHistory = new SmsHistory();
            $smsHistory->uniqid             = $uniqid;
            $smsHistory->customer_id        = $customer->id;
            $smsHistory->external_id        = $data['message_id'];
            $smsHistory->sender             = $credentials->sender;
            $smsHistory->msisdn             = $phone_number;
            $smsHistory->cost               = $data['req_cost'];
            $smsHistory->message            = $message;
            $smsHistory->sms_balance        = 0;
            $smsHistory->saveOrFail();
            
        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(443);
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
        $input      = file_get_contents('php://input');
        extract(@json_decode($input, true));

        if ( empty($msg_id) ) {
            return abort(403);
        }
        $msg_status = intval($msg_status);

        $uniqid = $request->route('uniqid');
        $check = SmsHistory::whereUniqid($uniqid)
            ->whereStatus(2)
            ->whereExternalId($msg_id)
            ->firstOrFail();

        if ( $msg_status <> 2) {
            $check->status = $msg_status;
            $check->saveOrFail();
        }

        die('OK');
    }
}
