<?php

namespace App\Http\Livewire\InstallationWizard;

use Livewire\Component;
use App\Models\Install as InstallModel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class Install extends Component
{
    public $wizard_title    = null;
    public $wizard_step     = null;
    public $disableNextbtn  = true;
    public $stepPositIndex  = 0;
    public $finishError     = null;

    public $navigationSteps = [
        'requirements',
        'database',
        'env',
        'mail',
        'site-config',
        'credential',
        'sms-api',
        'cpanel-api',
        'recaptcha',
        'bank-cards',
        'theming',
    ];

    public $optionalSteps = [
        'mail',
        'sms-api',
        'cpanel-api',
        'recaptcha',
        'bank-cards',
        'theming',
    ];

    public $queryString = [
        'wizard_step'       => ['as' => 'step'],
        'stepPositIndex'    => ['as' => 'position'],
    ];

    # ----------------------------------------------------
    # LISTENERS
    # ----------------------------------------------------

    protected $listeners = array(
        'installStepsListener'      => 'install_steps',
        'goNextListener'            => 'goNext',
        'disableNextbtnListener',
        'changeTitleListener',
    );

    public function changeTitleListener($title) {
        $this->wizard_title = $title;
    }

    private function search_step() {
        return array_search($this->wizard_step, $this->navigationSteps);
    }

    public function mount() {

        if ( ! $this->wizard_step ) {
            $this->wizard_step      = $this->navigationSteps[0];
        }
        $this->stepPositIndex       = $this->search_step();
        $notFoundAuthorizedIndex    = !in_array($this->stepPositIndex, [0, 1]);

        try {

            if ( (InstallModel::count() < count($this->navigationSteps)) && $notFoundAuthorizedIndex ) {
                return redirect()->route('install.start', ['component' => 1]);
            }

            if ( $entry = InstallModel::whereNull('completed_at')->first() ) {
                if ( $this->wizard_step <> $entry->step ) {
                    return redirect()->route('install.start', [
                        'step' => $entry->step
                    ]);
                }
            }

        } catch (\Exception $e) {
            # La table est introuvable et que nous sommes sur des étapes autres que les 2 premieres.
            if ( $notFoundAuthorizedIndex ) {
                return redirect()->route('install.start', ['component' => 2]);
            }
        }
    }

    private static function redirect_to_step($step) {
        return redirect()->route('install.start', compact('step'));
    }

    private static function updateCompletedAt($step, $value) {
        try {
            InstallModel::whereStep($step)->update(['completed_at' => $value]);
        } catch (\Exception $e) {
            
        }
    }

    public function goNext() {
        $position = $this->search_step();

        if ( empty($this->navigationSteps[$position+1]) ) {
            return false;
        }
        self::updateCompletedAt($this->wizard_step, now());

        return self::redirect_to_step( $this->navigationSteps[$position+1] );
    }

    public function goBack() {
        $position = $this->search_step();

        if ( ($pos = $position - 1) < 0 ) {
            return false;
        }
        $current = $this->navigationSteps[$pos];

        self::updateCompletedAt($current, null);

        return self::redirect_to_step( $current );
    }

    public function skipStep()
    {
        if (! in_array($this->wizard_step, $this->optionalSteps, true)) {
            return false;
        }

        return $this->goNext();
    }

    public function installationSummary()
    {
        return [
            'Base de données' => $this->stepIsCompleted('database') ? 'Configurée' : 'À finaliser',
            'Variables du site' => $this->stepIsCompleted('env') ? 'Configurées' : 'À finaliser',
            'SMTP' => $this->stepIsCompleted('mail') ? 'Configuré ou ignoré' : 'Optionnel',
            'Identité du site' => $this->stepIsCompleted('site-config') ? 'Configurée' : 'À finaliser',
            'Compte administrateur' => $this->stepIsCompleted('credential') ? 'Créé' : 'À finaliser',
            'SMS' => $this->stepIsCompleted('sms-api') ? 'Configuré ou ignoré' : 'Optionnel',
            'cPanel' => $this->stepIsCompleted('cpanel-api') ? 'Configuré ou ignoré' : 'Optionnel',
            'reCAPTCHA' => $this->stepIsCompleted('recaptcha') ? 'Configuré ou ignoré' : 'Optionnel',
            'Cartes bancaires' => $this->stepIsCompleted('bank-cards') ? 'Configurées ou ignorées' : 'Optionnel',
            'Thème' => $this->stepIsCompleted('theming') ? 'Configuré ou ignoré' : 'Optionnel',
        ];
    }

    private function stepIsCompleted($step)
    {
        try {
            return InstallModel::whereStep($step)->whereNotNull('completed_at')->exists();
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function finish()
    {
        $this->finishError = null;
        $stepsWereCompleted = false;

        try {
            $lockPath = storage_path('app/installed.lock');
            $lockDirectory = dirname($lockPath);

            File::ensureDirectoryExists($lockDirectory, 0755, true);

            if (! is_writable($lockDirectory)) {
                throw new \RuntimeException("Le dossier storage/app doit être accessible en écriture.");
            }

            Artisan::call('update:db-config');
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');

            InstallModel::query()
                ->whereNull('completed_at')
                ->update(['completed_at' => now()]);
            $stepsWereCompleted = true;

            if (File::put($lockPath, now()->toDateTimeString()) === false) {
                throw new \RuntimeException("Impossible de verrouiller l’installation.");
            }

            return redirect()->route('guest.index.root');
        } catch (\Throwable $e) {
            if ($stepsWereCompleted && ! file_exists(storage_path('app/installed.lock'))) {
                InstallModel::whereStep($this->navigationSteps[count($this->navigationSteps) - 1])
                    ->update(['completed_at' => null]);
            }

            $this->finishError = 'La finalisation a échoué : ' . $e->getMessage();
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
        }
    }

    public function disableNextbtnListener($value) {
        $this->disableNextbtn = $value;
    }

    public function install_steps() {
        $this->disableNextbtn = true;

        try {
            
            $data = [];
            foreach ($this->navigationSteps as $index => $key) {
                $data[] = [
                    'step' => $key,
                    'completed_at' => ($index < $this->stepPositIndex) ? now() : null
                ];
            }
            InstallModel::insert($data);

            $this->disableNextbtn = false;

        } catch (\Exception $e) {
            $this->finishError = 'Impossible de préparer les étapes : ' . $e->getMessage();
        }
    }

    # ----------------------------------------------------
    # LISTENERS
    # ----------------------------------------------------

    public function render()
    {
        return view('livewire.installation-wizard.install')
            ->layout('layouts.installation');
    }
}
