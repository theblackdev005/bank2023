<?php

namespace App\Http\Livewire\InstallationWizard;

use App\Models\EnvFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use PDO;

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
    public $connectionMessage = null;

    protected $listeners = ['checkStepOnChild'];

    public function init()
    {
        $this->emitUp('disableNextbtnListener', true);
        $this->emitUp('changeTitleListener', 'Base de données.');
    }

    public function mount()
    {
        foreach (EnvFile::get('DB_') as $key => $value) {
            $this->{$key} = $value;
            $this->data[$key] = $value;
        }
    }

    public function db_connexion_checker()
    {
        return $this->testConnection();
    }

    public function checkStepOnChild()
    {
        if ($this->dbIsConnected) {
            $this->emitUp('goNextListener');
        }
    }

    public function submit()
    {
        return $this->testConnection();
    }

    public function testConnection()
    {
        $this->emitUp('disableNextbtnListener', true);
        $this->dbIsConnected = false;
        $this->connectionMessage = null;

        try {
            $data = $this->validate($this->rules());
            $this->assertDatabaseConnection($data);

            EnvFile::regenerate(EnvFile::set($data));
            $this->applyRuntimeDatabaseConfig($data);

            $this->dbIsConnected = true;
            $this->connectionMessage = 'Connexion réussie. Vous pouvez lancer la migration.';
            $this->emitUp('disableNextbtnListener', false);
        } catch (\Throwable $e) {
            $this->emitUp('disableNextbtnListener', true);
            $this->addError('danger', 'Connexion impossible : ' . $e->getMessage());
        }
    }

    public function resetDatabaseConfig()
    {
        $this->DB_CONNECTION = 'mysql';
        $this->DB_HOST = '127.0.0.1';
        $this->DB_PORT = '3306';
        $this->DB_DATABASE = '';
        $this->DB_USERNAME = '';
        $this->DB_PASSWORD = '';
        $this->dbIsConnected = false;
        $this->connectionMessage = null;
        $this->console_output = null;

        $data = [
            'DB_CONNECTION' => $this->DB_CONNECTION,
            'DB_HOST' => $this->DB_HOST,
            'DB_PORT' => $this->DB_PORT,
            'DB_DATABASE' => $this->DB_DATABASE,
            'DB_USERNAME' => $this->DB_USERNAME,
            'DB_PASSWORD' => $this->DB_PASSWORD,
        ];

        EnvFile::regenerate(EnvFile::set($data), false);
        $this->emitUp('disableNextbtnListener', true);
        $this->addError('info', 'Configuration de la base de données réinitialisée. Vous pouvez recommencer.');
    }

    public function migrate()
    {
        $this->console_output = null;

        if (! $this->dbIsConnected) {
            return $this->addError('danger', 'Testez d’abord la connexion à la base de données.');
        }

        try {
            Artisan::call('db:wipe', ['--force' => true]);
            Artisan::call('migrate:refresh', ['--seed' => true, '--force' => true]);
            $this->console_output = trim(Artisan::output()) ?: 'Migration terminée avec succès.';
            $this->emitUp('installStepsListener');
        } catch (\Throwable $e) {
            $this->console_output = 'Échec de la migration : ' . $e->getMessage();
        }
    }

    protected function rules()
    {
        return [
            'DB_CONNECTION' => 'required|string|in:mysql',
            'DB_HOST' => 'required|string',
            'DB_PORT' => 'required|integer',
            'DB_DATABASE' => 'required|string',
            'DB_USERNAME' => 'required|string',
            'DB_PASSWORD' => 'nullable|string',
        ];
    }

    protected function assertDatabaseConnection(array $data)
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $data['DB_HOST'],
            $data['DB_PORT'],
            $data['DB_DATABASE']
        );

        $pdo = new PDO($dsn, $data['DB_USERNAME'], $data['DB_PASSWORD'] ?? '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5,
        ]);

        $pdo = null;
    }

    protected function applyRuntimeDatabaseConfig(array $data)
    {
        config([
            'database.default' => $data['DB_CONNECTION'],
            'database.connections.mysql.host' => $data['DB_HOST'],
            'database.connections.mysql.port' => $data['DB_PORT'],
            'database.connections.mysql.database' => $data['DB_DATABASE'],
            'database.connections.mysql.username' => $data['DB_USERNAME'],
            'database.connections.mysql.password' => $data['DB_PASSWORD'] ?? '',
        ]);

        DB::purge('mysql');
        DB::reconnect('mysql');
    }

    public function render()
    {
        return view('livewire.installation-wizard.steps.database')
            ->layout('layouts.installation');
    }
}
