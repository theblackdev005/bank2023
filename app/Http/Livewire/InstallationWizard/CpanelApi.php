<?php

namespace App\Http\Livewire\InstallationWizard;

use Livewire\Component;
use App\Models\CpanelConfig;
use App\Models\Admin;

class CpanelApi extends Component
{

    public $username        = null;
    public $apikey          = null;
    public $domain_name     = null;

    public $api = [];

    protected $listeners = array(
        'checkStepOnChild',
    );

    public function mount()
    {
        if ( $this->api = CpanelConfig::first() ) {
            foreach (['username', 'apikey', 'domain_name'] as $key) {
                $this->$key = $this->api->$key;
            }
        }
    }

    public function init()
    {
        $this->emitUp('disableNextbtnListener', false);
        $this->emitUp('changeTitleListener', 'Api Cpanel.');
    }

    public function checkStepOnChild() {
        $this->emitUp('goNextListener');
    }

    public function submit() {

        try {
            extract( $this->validate([
                'username'      => ['required', 'string'],
                'apikey'        => ['required', 'string'],
                'domain_name'   => ['required', 'string'],
            ]) );

            if ( !$this->api ) {
                $this->api = new CpanelConfig();
            }

            $this->api->username    = $username;
            $this->api->apikey      = $apikey;
            $this->api->domain_name = $domain_name;
            $this->api->admin_id    = Admin::firstOrFail()->id;
            $this->api->enabled_at  = now();
            $this->api->saveOrFail();

            return $this->addError('success', "Informations cpanel mise à jour !");
            
        } catch (\Exception $e) {
            return $this->addError('danger', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.installation-wizard.steps.cpanel-api');
    }
}
