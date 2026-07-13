<?php

namespace App\Http\Livewire\InstallationWizard;

use Livewire\Component;
use App\Models\EnvFile;

use App\Notifications\CustomerActivityToAdminNotification;
use Illuminate\Support\Facades\Notification;

class Mail extends Component
{
    public $MAIL_HOST;
    public $MAIL_PORT;
    public $MAIL_USERNAME;
    public $MAIL_PASSWORD;
    public $MAIL_ENCRYPTION;
    public $MAIL_FROM_ADDRESS;

    public $data = [];

    protected $listeners = array(
        'checkStepOnChild',
    );

    public function init()
    {
        $this->emitUp('changeTitleListener', 'Configuration SMTP.');
        $this->emitUp('disableNextbtnListener', true);

        try {
            $this->check_connection();
        } catch (\Exception $e) {
            
        }
    }

    private function check_connection()
    {
        # Vérifier la connexion SMTP
        \Mail::getSwiftMailer()->getTransport()->start();

        $this->emitUp('disableNextbtnListener', false);
    }

    public function mount()
    {
        foreach (EnvFile::get('MAIL_') as $key => $value) {
            if ( in_array($key, ['MAIL_FROM_NAME', 'MAIL_MAILER']) ) {
                continue;
            }
            $this->$key = $value;
            $this->data[$key] = $value;
        }
    }

    public function checkStepOnChild() {
        $this->emitUp('goNextListener');
    }


    public function submit() {
        $this->emitUp('disableNextbtnListener', true);

        try {
            $data = $this->validate([
                'MAIL_HOST'             => 'required|string',
                'MAIL_PORT'             => 'required|integer',
                'MAIL_USERNAME'         => 'required|string',
                'MAIL_PASSWORD'         => 'required|string',
                'MAIL_ENCRYPTION'       => 'required|string',
                'MAIL_FROM_ADDRESS'     => 'required|email',
            ]);

            $posts = EnvFile::set($data);
            EnvFile::regenerate($posts);

            # Vérifier la connexion SMTP
            $this->check_connection();

            return $this->addError('success', "Informations SMTP mise à jour !");
            
        } catch (\Exception $e) {
            return $this->addError('danger', $e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.installation-wizard.steps.mail');
    }
}
