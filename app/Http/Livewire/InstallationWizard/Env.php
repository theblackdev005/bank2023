<?php

namespace App\Http\Livewire\InstallationWizard;

use Livewire\Component;
use App\Models\EnvFile;

class Env extends Component
{

    public $APP_ENV;
    public $APP_DEBUG;
    public $APP_URL;

    public $data = [];
    public $data_input_radio = [
        'APP_ENV' => ['local', 'production'],
        'APP_DEBUG' => ['true', 'false'],
    ];

    protected $listeners = array(
        'checkStepOnChild',
    );

    public function init()
    {
        $this->emitUp('disableNextbtnListener', true);
        $this->emitUp('changeTitleListener', "Variables d'environnement");
    }

    public function mount()
    {
        foreach (EnvFile::get('APP_') as $key => $value) {
            if ( in_array($key, ['APP_KEY', 'APP_NAME']) ) {
                continue;
            }
            $this->$key = $value;
            $this->data[$key] = $value;
        }

        if (empty($this->APP_URL) || in_array($this->APP_URL, ['http://localhost', 'https://localhost'], true)) {
            $this->APP_URL = request()->getSchemeAndHttpHost();
            $this->data['APP_URL'] = $this->APP_URL;
        }

        if (empty($this->APP_ENV) || $this->APP_ENV === 'local') {
            $this->APP_ENV = 'production';
            $this->data['APP_ENV'] = 'production';
        }

        if ($this->APP_DEBUG === 'true' || $this->APP_DEBUG === true || empty($this->APP_DEBUG)) {
            $this->APP_DEBUG = 'false';
            $this->data['APP_DEBUG'] = 'false';
        }
    }

    public function checkStepOnChild() {
        $this->emitUp('goNextListener');
    }

    public function submit() {
        $this->emitUp('disableNextbtnListener', true);

        try {
            $data = $this->validate([
                'APP_ENV'   => 'required',
                'APP_DEBUG' => 'required|string',
                'APP_URL'   => 'required|url',
            ]);

            $posts = EnvFile::set($data);
            EnvFile::regenerate($posts);

            $this->emitUp('disableNextbtnListener', false);

            return $this->addError('success', "Variables d'environnement mise à jour !");
            
        } catch (\Exception $e) {
            return $this->addError('danger', $e->getMessage());
        }
    }

    public function render()
    {
        return view("livewire.installation-wizard.steps.env");
    }
}
