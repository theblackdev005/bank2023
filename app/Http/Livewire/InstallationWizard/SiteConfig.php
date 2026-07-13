<?php

namespace App\Http\Livewire\InstallationWizard;

use Livewire\Component;
use App\Models\Config;
use App\Models\Language;

class SiteConfig extends Component
{

    public $posts = [];
    public $configs = [];

    protected $listeners = array(
        'checkStepOnChild',
    );

    public function mount()
    {
        $this->configs = Config::where('input_type', '<>', 'boolean')->get();

        foreach ($this->configs as $config) {
            $this->posts[$config->name] = $config->value;
        }
    }

    public function init()
    {
        $this->emitUp('disableNextbtnListener', true);
        $this->emitUp('changeTitleListener', 'Configuration du site.');
    }

    public function checkStepOnChild() {
        return $this->emitUp('goNextListener');
    }

    public function submit() {
        $this->emitUp('disableNextbtnListener', true);

        try {
            extract( $this->validate([
                'posts'             => 'required|array',
                'posts.*.*'         => 'required',
            ]) );

            foreach ($this->configs as $config) {
                
                if ( $config->input_type === 'boolean' ) {
                    $config->value = !empty($posts[$config->name]) ? 1 : 0;
                } else {
                    $config->value = $posts[$config->name];

                    # APP_NAME
                    Config::generate_env_appName($config);

                    # DEFAULT_SITE_LANGUAGE
                    if ( $config->name == 'DEFAULT_SITE_LANGUAGE' ) {
                        if ( ! $check = Language::whereIso($config->value)->first() ) {
                            continue;
                        }
                        Language::query()->update(['enabled_at' => null]);
                        $check->update(['enabled_at' => now()]);
                    }
                }
                
                $config->save();
            }

            # REFRESH CASH
            Config::refreshCache();

            $this->emitUp('disableNextbtnListener', false);
            
        } catch (\Exception $e) {
            return $this->addError('danger', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.installation-wizard.steps.site-config');
    }
}
