<?php

namespace App\Http\Livewire\InstallationWizard;

use Livewire\Component;
use App\Models\GoogleRecaptcha;

class Recaptcha extends Component
{

    public $site_key        = null;
    public $secret_key      = null;

    public $api = [];

    protected $listeners = array(
        'checkStepOnChild',
    ); 

    public function mount()
    {
        if ( $this->api = GoogleRecaptcha::first() ) {
            foreach (['site_key', 'secret_key'] as $key) {
                $this->$key = $this->api->$key;
            }
        }
    }

    public function init()
    {
        $this->emitUp('disableNextbtnListener', false);
        $this->emitUp('changeTitleListener', 'Google Recaptcha.');
    }

    public function checkStepOnChild() {
        $this->emitUp('goNextListener');
    }

    public function submit() {

        try {
            extract( $this->validate([
                'site_key'      => ['required', 'string'],
                'secret_key'    => ['required', 'string'],
            ]) );

            if ( !$this->api ) {
                $this->api = new GoogleRecaptcha();
            }

            $this->api->site_key    = $site_key;
            $this->api->secret_key  = $secret_key;
            $this->api->enabled_at  = now();
            $this->api->saveOrFail();

            return $this->addError('success', "Informations google recaptcha mise à jour !");
            
        } catch (\Exception $e) {
            return $this->addError('danger', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.installation-wizard.steps.recaptcha');
    }
}
