<?php

namespace App\Http\Livewire\InstallationWizard;

use Livewire\Component;
use App\Models\Install as InstallModel;
use Illuminate\Support\Facades\Artisan;

class Install extends Component
{
    public $wizard_title    = null;
    public $wizard_step     = null;
    public $disableNextbtn  = true;
    public $stepPositIndex  = 0;

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

    public function finish()
    {
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');
        Artisan::call('update:db-config');

        InstallModel::query()
            ->whereNull('completed_at')
            ->update(['completed_at' => now()]);

        return redirect()->route('guest.index.root');
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
            dd( $e->getMessage() );
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
