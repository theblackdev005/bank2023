<?php

namespace App\Http\Livewire\InstallationWizard;

use Livewire\Component;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Credential extends Component
{

    public $username    = 'administrator';
    public $password    = null;
    public $email       = SITE_EMAIL;

    public $provider = [];

    protected $listeners = array(
        'checkStepOnChild',
    );

    private static function administrator() {
        return Admin::whereSuperAdmin('1')->first();
    }

    public function mount()
    {
        $this->password = Str::random(10);

        if ( $this->provider = self::administrator() ) {
            foreach (['username', 'email'] as $key) {
                $this->$key = $this->provider->$key;
            }
        }
    }

    public function init()
    {
        $this->emitUp('disableNextbtnListener', $this->provider ? false : true );
        $this->emitUp('changeTitleListener', 'Compte Administrateur.');
    }

    public function checkStepOnChild() {
        $this->emitUp('goNextListener');
    }

    public function submit() {

        if ( self::administrator() ) {
            return $this->addError('warning', "Un administrateur a été déja crée !");
        }

        try {
            extract( $this->validate([
                'username'    => ['required', 'string', 'unique:admins,username'],
                'email'       => ['required', 'email', 'unique:admins,email'],
                'password'    => ['required', 'string'],
            ]) );

            $admin = new Admin();
            $admin->username    = $username;
            $admin->email       = $email;
            $admin->password    = Hash::make($password);
            $admin->super_admin = '1';

            # ---------------------------------------------------
            # ENVOYER UN MAIL
            # ---------------------------------------------------
            
            $message  = translate(731) . "\n";
            $message .= translate(732) . "\n\n";
            # Adresse email
            $message .= translate(170) . ": <b>" . $email . "</b>\n";
            # Nom d'utilisateur
            $message .= translate(733) . ": <b>" . $username . "</b>\n";
            # Mot de passe
            $message .= translate(185) . ": <b>" . $password . "</b>\n";
            # Lien de connexion
            $message .= translate(140) . ": <b>" . routeWithLocale('admin.login') . "</b>";

            $admin->sendCustomerActivityToAdmin([
                'title' => translate(483),
                'message' => $message,
            ]);
            $admin->saveOrFail();

            # disableNextbtnListener
            $this->emitUp('disableNextbtnListener', false);

            return $this->addError('success', "Un administrateur a été ajouté !");
            
        } catch (\Exception $e) {
            return $this->addError('danger', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.installation-wizard.steps.credential');
    }
}
