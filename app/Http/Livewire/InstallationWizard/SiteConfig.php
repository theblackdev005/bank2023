<?php

namespace App\Http\Livewire\InstallationWizard;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Config;
use App\Models\Language;
use RuntimeException;

class SiteConfig extends Component
{
    use WithFileUploads;

    public $posts = [];
    public $configs = [];
    public $logo;
    public $favicon;
    public $logoExists = false;
    public $faviconExists = false;
    public $visualAssetVersion;

    protected $listeners = array(
        'checkStepOnChild',
    );

    public function mount()
    {
        $this->configs = Config::where('input_type', '<>', 'boolean')->get();
        $this->logoExists = is_file(public_path('assets/images/logo.png'));
        $this->faviconExists = is_file(public_path('assets/images/icons/favicon.png'));
        $this->visualAssetVersion = max(
            (int) @filemtime(public_path('assets/images/logo.png')),
            (int) @filemtime(public_path('assets/images/icons/favicon.png'))
        );

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

    public function updatedLogo()
    {
        $this->validateOnly('logo', [
            'logo' => ['nullable', 'image', 'mimes:png'],
        ]);
    }

    public function updatedFavicon()
    {
        $this->validateOnly('favicon', [
            'favicon' => ['nullable', 'image', 'mimes:png'],
        ]);
    }

    private function saveVisualAsset($upload, $relativePath)
    {
        if (!$upload) {
            return;
        }

        $target = public_path($relativePath);
        $directory = dirname($target);

        if (!is_dir($directory) || !is_writable($directory)) {
            throw new RuntimeException("Le dossier {$directory} doit être accessible en écriture.");
        }

        if (file_exists($target) && !is_writable($target)) {
            throw new RuntimeException("Le fichier {$target} doit être accessible en écriture.");
        }

        $contents = file_get_contents($upload->getRealPath());

        if ($contents === false || file_put_contents($target, $contents, LOCK_EX) === false) {
            throw new RuntimeException("Impossible d'enregistrer le fichier {$relativePath}.");
        }
    }

    public function submit() {
        $this->emitUp('disableNextbtnListener', true);

        try {
            extract( $this->validate([
                'posts'             => 'required|array',
                'posts.*'           => 'nullable',
                'logo'              => ['nullable', 'image', 'mimes:png'],
                'favicon'           => ['nullable', 'image', 'mimes:png'],
            ]) );

            foreach ($this->configs as $config) {
                
                if ( $config->input_type === 'boolean' ) {
                    $config->value = !empty($posts[$config->name]) ? 1 : 0;
                } else {
                    $config->value = $posts[$config->name] ?? '';

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

            $this->saveVisualAsset($this->logo, 'assets/images/logo.png');
            $this->saveVisualAsset($this->favicon, 'assets/images/icons/favicon.png');

            $this->logoExists = $this->logoExists || (bool) $this->logo;
            $this->faviconExists = $this->faviconExists || (bool) $this->favicon;

            $this->logo = null;
            $this->favicon = null;
            $this->visualAssetVersion = time();

            # REFRESH CASH
            Config::refreshCache();

            $this->emitUp('disableNextbtnListener', false);
            return $this->emitUp('goNextListener');
            
        } catch (\Exception $e) {
            $this->emitUp('disableNextbtnListener', true);
            return $this->addError('danger', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.installation-wizard.steps.site-config');
    }
}
