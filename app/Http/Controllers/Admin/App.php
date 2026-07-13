<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin;

use App\Models\Testimonial;
use App\Models\Mailpro;
use App\Models\Config;
use App\Models\Customer;
use App\Models\Currency;
use App\Models\Country;
use App\Models\Contact;
use App\Models\Language;

class App extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin      = admin();
        $customers  = $admin->customers();

        # Nombre de clients actifs
        $stats["verified_customers"] = $admin->customers()
            ->qyVerifiedAndActif()
            ->count();
        
        # Nombre de clients bannis
        $stats["banned_customers"] = $admin->customers()
            ->qyBanned()
            ->count();
        
        # Nombre de clients en attentes d'êtres validés
        $stats["pending_customers"] = Customer::whereNull('email_verified_at')
            ->count();
        
        # Tous les administrateurs du site
        $stats["admins"] = Admin::count();
        
        # Membres actuellement connectés
        $stats["sessions"] = $admin->sessions()
            ->count();

        # Messages envoyés via le formulaire de contact
        $stats["contacts"] = self::get_contact()->count();
        
        # Cartes en attente de validation.
        $stats["cards"] = $admin->cards()
            ->whereNull('approved_at')
            ->count();

        # Comptes paypal en attente de validation.
        $stats["paypal"] = $admin->paypal()
            ->whereNull('approved_at')
            ->count();

        # Comptes bancaires en attentes de validation.
        $stats["recipients"] = $admin->recipients()
            ->whereNull('approved_at')
            ->count();
        
        # Demandes de prêts en attentes
        $stats["pending_loans_request"] = $admin->loans()
            ->whereNull('approved_at')
            ->count();
        
        # Sms
        $stats["sms"] = $admin->sms()
            ->count();

        # Ribs
        $stats["ribs"] = $admin->ribs()
            ->count();

        # Testimonial
        $stats["testimonials"] = $admin->testimonials()->count();

        # Mailpro
        $stats["mails_pro"] = $admin->mails()->count();

        # Config
        $stats["configs"] = Config::whereReadonly(false)->count();

        # Currency
        $stats["currencies"] = Currency::active()->count();

        # Country
        $stats["countries"] = Country::active()->count();

        # Language
        $stats["languages"] = Language::active()->count();

        $stats = collect($stats);

        return view('pages.admin.dashboard', compact('admin', 'stats'));
    }


    public function helps()
    {
        return view('pages.admin.helps');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        doLogout($request, true);

        return redirectWithLocale('admin.login');
    }
}
