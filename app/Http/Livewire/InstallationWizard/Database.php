<?php

namespace App\Http\Livewire\InstallationWizard;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\EnvFile;
use Illuminate\Support\Facades\Artisan;

class Database extends Component
{

    public $DB_CONNECTION;
    public $DB_HOST;
    public $DB_PORT;
    public $DB_DATABASE;
    public $DB_USERNAME;
    public $DB_PASSWORD;

    public $data = [];
    public $console_output = null;
    public $dbIsConnected = false;

    protected $listeners = array(
        'checkStepOnChild',
    );

    public function init()
    {
        $this->emitUp('disableNextbtnListener', true);
        $this->emitUp('changeTitleListener', 'Base de données.');
    }

    public function mount()
    {
        foreach (EnvFile::get('DB_') as $key => $value) {
            $this->$key = $value;
            $this->data[$key] = $value;
        }
    }

    # VERIFIER LA CONNEXION 
    public function db_connexion_checker()
    {
        try {
            $dbconnect = DB::connection()->getPDO();
            $dbname = DB::connection()->getDatabaseName();

            $this->dbIsConnected = true;

        } catch (\Exception $e) {
            $this->dbIsConnected = false;
        }
        $this->emitUp('disableNextbtnListener', !$this->dbIsConnected);
    }

    public function checkStepOnChild() {
        if ( $this->dbIsConnected ) {
            $this->emitUp('goNextListener');
        }
    }

    public function submit() {
        $this->emitUp('disableNextbtnListener', true);
        
        try {
            $data = $this->validate([
                'DB_CONNECTION'     => 'required|string',
                'DB_HOST'           => 'required|string',
                'DB_PORT'           => 'required|integer',
                'DB_DATABASE'       => 'required|string',
                'DB_USERNAME'       => 'required|string',
                'DB_PASSWORD'       => 'nullable|string',
            ]);

            $posts = EnvFile::set($data);
            EnvFile::regenerate($posts);
            
            Artisan::call('key:generate');

            return redirect()->route('install.start', ['step' => 'database']);
        } catch (\Exception $e) {
            return $this->addError('danger', $e->getMessage());
        }
    }


    public function migrate() {
        $this->console_output = null;
        
        try {
            Artisan::call('db:wipe');
            Artisan::call('migrate:refresh --seed');
            $this->console_output = Artisan::output();

            $this->emitUp('installStepsListener');
        } catch (\Exception $e) {
            $this->console_output = 'Console Error !';
        }
    }

    public function render()
    {
        return view('livewire.installation-wizard.steps.database')
            ->layout('layouts.installation');;
    }
}
