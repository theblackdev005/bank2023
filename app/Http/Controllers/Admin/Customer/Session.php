<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CustomerSession;

class Session extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = admin();

        CustomerSession::whereHas('customer', function ($query) use ($admin) {
                $query->where('admin_id', $admin->id);
            })
            ->where('status', 1)
            ->where('last_seen_at', '<', now()->subMinutes(CustomerSession::ACTIVE_WINDOW_MINUTES))
            ->update(['status' => 0]);

        $sessions = $admin->sessions()
            ->where('customer_sessions.last_seen_at', '>=', now()->subMinutes(CustomerSession::ACTIVE_WINDOW_MINUTES))
            ->orderByDesc('customer_sessions.last_seen_at')
            ->paginate( PAGINATION_PER_PAGE )
            ->withQueryString();

        return view("pages.admin.customers.sessions", compact(
            'sessions'
        ));
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        extract( $request->validate([
            "customer_id" => ["required", "exists:customers,id"],
            "session_id" => ["required", "exists:customer_sessions,id"],
        ]) );
        $admin  = admin();

        try {
            if ( !$admin->customers()->whereId($customer_id)->exists() ) {
                return throw_exception();
            }

            $session = CustomerSession::whereId($session_id)
                ->whereCustomerId($customer_id)
                ->whereStatus(1)
                ->firstOrFail();

            $session->status = 0;
            $session->saveOrFail();
            
        } catch (\Exception $e) {
            return back_With_Error();
        }

        return back_With_Success(663);
    }
}
