<?php

namespace App\Http\Livewire\InstallationWizard;

use Livewire\Component;
use App\Models\SmsConfig;
use App\Models\Admin;

class SmsApi extends Component
{

    public $username    = null;
    public $password    = null;
    public $sender      = null;

    public $api = [];

    protected $listeners = array(
        'checkStepOnChild',
    ); 

    public function mount()
    {
        if ( $this->api = SmsConfig::first() ) {
            foreach (['username', 'password', 'sender'] as $key) {
                $this->$key = $this->api->$key;
            }
        }
    }

    public function init()
    {
        $this->emitUp('disableNextbtnListener', false);
        $this->emitUp('changeTitleListener', 'Api SMS.');
    }

    public function checkStepOnChild() {
        $this->emitUp('goNextListener');
    }

    public function submit() {

        try {
            extract( $this->validate([
                'username'    => ['required', 'string'],
                'password'    => ['required', 'string'],
                'sender'      => ['required', 'string', 'max:11'],
            ]) );

            if ( !$this->api ) {
                $this->api = new SmsConfig();
            }

            $this->api->username    = $username;
            $this->api->password    = $password;
            $this->api->sender      = $sender;
            $this->api->admin_id    = Admin::firstOrFail()->id;
            $this->api->enabled_at  = now();
            $this->api->saveOrFail();

            return $this->addError('success', "Informations mise à jour !");
            
        } catch (\Exception $e) {
            return $this->addError('danger', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.installation-wizard.steps.sms-api');
    }
}
