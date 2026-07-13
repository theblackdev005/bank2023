<?php

namespace App\Http\Livewire\InstallationWizard;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use App\Models\Config;

class Theming extends Component
{
    public $preset_themes = [];
    public $current_preset = null;

    public $queryString = [
        'current_preset'       => ['as' => 'preset'],
    ];

    public $theming = [];

    public $SITE_PRIMARY_COLOR = null;
    public $SITE_PRIMARY_COLOR_POSITION = -1; // FAKE POSITION

    private $all_css_files = [];
    private $all_other_files = [];

    private $themeConfigFile = null;
    public $themeConfigFileData = [];
    private $theme_generator_dir = null;
    private $theme_generator_asset_dir = null;
    private $theme_generator_preset_dir = null;

    public $disable_generate_btn = true;

    public $listeners = array(
        'checkStepOnChild',
    );

    public function checkStepOnChild() {
        return $this->emitUp('goNextListener');
    }

    public function init() {
        $this->emitUp('disableNextbtnListener', false);
        $this->emitUp('changeTitleListener', 'Theming.');
    }

    public function __construct() {
        $this->theme_generator_dir          = resource_path('theme-generator' . DS);
        $this->theme_generator_preset_dir   = resource_path('theme-generator' . DS . 'presets' . DS);
        $this->themeConfigFile              = $this->theme_generator_dir . 'theme-generator.json';
        $this->theme_generator_asset_dir    = $this->theme_generator_dir . 'assets' . DS;;

        if ( !is_dir($this->theme_generator_dir) ) {
            mkdir($this->theme_generator_dir, 0777, true);
        }

        if ( is_file($this->themeConfigFile) ) {
            $this->themeConfigFileData = json_decode(file_get_contents($this->themeConfigFile), true);
        }
        $this->disable_generate_btn__callback();
    }

    public function mount()
    {
        foreach ($this->themeConfigFileData ?? [] as $color) {
            $this->theming[] = $color;
        }

        $this->all_preset_files();
        $this->change_theme_using_preset();
    }

    private function all_preset_files() {
        $this->preset_themes = array_diff(scandir($this->theme_generator_preset_dir), ['.', '..']);
    }

    public function change_theme_using_preset() {
        if ( is_null($this->current_preset) ) {
            return false;
        }
        $toLowerCaseArray = array_map('strtolower', array_keys($this->themeConfigFileData ?? []));

        try {
            $content = json_decode(strtolower(file_get_contents($this->theme_generator_preset_dir . $this->current_preset)), true);
            foreach ($toLowerCaseArray as $index => $color) {
                if ( !empty($content[$color]) ) {
                    $this->theming[$index] = $content[$color];
                }
            }
        } catch (\Exception $e) {
            return $this->addError('danger', "Ce theme n'est pas défini !");
        }
    }

    private function disable_generate_btn__callback() {
        $this->disable_generate_btn = (is_dir($this->theme_generator_asset_dir) && $this->themeConfigFileData);
    }

    private function generate_config_file__callback() {
        return file_put_contents($this->themeConfigFile, json_encode($this->themeConfigFileData, JSON_PRETTY_PRINT));
    }

    private function get_all_css_paths($dir)
    {
        if ( !is_dir($dir) ) {
            return $this->addError('danger', 'Le dossier /theme-generator/assets/ existe pas !');
        }

        foreach (scandir($dir) as $file) {
            $file = trim($file, '.');
            if ( !empty($file) ) {
                
                $fullDirName = $dir . $file;
                if ( is_dir($fullDirName) ) {
                    $this->get_all_css_paths($fullDirName . DS);
                } else {
                    if ( pathinfo($fullDirName, PATHINFO_EXTENSION) <> 'css' ) {
                        $this->all_other_files[] = $fullDirName;
                        continue;
                    }

                    $this->all_css_files[] = $fullDirName;
                }
            }
        }
    }

    public function delete_color($x_color)
    {
        $this->theming = [];
        foreach ($this->themeConfigFileData as $color => $replace) {
            if ( $color == $x_color ) {
                unset( $this->themeConfigFileData[$color]);
            } else {
                $this->theming[] = $color;
            }
        }
        $this->generate_config_file__callback();
        $this->disable_generate_btn__callback();
    }

    public function submit_default_color($color, $position) {

        $this->SITE_PRIMARY_COLOR           = $color;
        $this->SITE_PRIMARY_COLOR_POSITION  = $position;

        try {
            if ( !is_null($color) ) {
                Config::whereName('SITE_PRIMARY_COLOR')->update(['value' => $color]);

                # REFRESH CASH
                Config::refreshCache();
            }
        } catch (\Exception $e) {
            return $this->addError('danger', $e->getMessage());
        }
    }

    public function submit()
    {
        set_time_limit(0);

        extract( $this->validate([
            'theming'      => ['required', 'array'],
            'theming.*'  => ['nullable', 'string'],
        ]) );

        try {
            $this->get_all_css_paths($this->theme_generator_asset_dir);

            $resColors       = [];
            $fromColorArray  = array_keys($this->themeConfigFileData);

            foreach (array_merge($this->all_other_files, $this->all_css_files) as $cssFile) {

                $extension = pathinfo($cssFile, PATHINFO_EXTENSION);

                $fileNewDestination = str_ireplace('resources'. DS .'theme-generator' . DS, 'public' . DS, $cssFile);
                if ( !is_dir($dirx = dirname($fileNewDestination)) ) {
                    mkdir($dirx, 0777, true);
                }

                if ( ($extension <> 'css') && is_file($fileNewDestination) ) {
                    continue;
                }
                
                $contentOfCssFile = file_get_contents($cssFile);

                if ( $extension == 'css' ) {

                    foreach ($theming as $colorIndex => $toColor) {
                        $fromColor          = $fromColorArray[$colorIndex];

                        $toColor            = !empty($toColor) ? $toColor : $fromColor;
                        $contentOfCssFile   = str_ireplace($fromColor, $toColor, $contentOfCssFile);

                        if ( ! empty($this->themeConfigFileData[$fromColor]) ) {
                            $this->themeConfigFileData[$fromColor] = $toColor;
                        }
                    }
                }

                file_put_contents($fileNewDestination, $contentOfCssFile);
            }
            Artisan::call('view::cache');

            # generate_config_file__callback
            $this->generate_config_file__callback();

            return $this->addError('success', 'Les couleurs css ont été bien regénérées !');
        } catch (\Exception $e) {
            return $this->addError('danger', $e->getMessage());
        }
    }

    public function create_theme_file()
    {
        if ( !is_dir($dir = $this->theme_generator_asset_dir) ) {
            mkdir($dir, 0777, true);

            // recursive_copy(public_path('assets' . DS), $dir);
        }
        $this->get_all_css_paths($dir);

        $resColors = [];
        foreach ($this->all_css_files as $file) {

            # Traitement
            $ct = file_get_contents($file);

            preg_match_all("/#([a-f0-9]{3}){1,2}\b/i", $ct, $matchesHEX);
            preg_match_all("/rgba\([0-9\,\.]+\)/i", $ct, $matchesRGBA);
            preg_match_all("/rgb\([0-9\,]+\)/i", $ct, $matchesRGB);

            foreach ($matchesHEX[0] as $value) {
                $resColors[] = $value;
            }
            foreach ($matchesRGBA[0] as $value) {
                $resColors[] = $value;
            }
            foreach ($matchesRGB[0] as $value) {
                $resColors[] = $value;
            }
        }

        $this->themeConfigFileData = [];
        foreach ($resColors as $color) {
            $this->themeConfigFileData[ $color ] = $color;
        }
        $this->generate_config_file__callback();
        $this->disable_generate_btn__callback();
        
        return $this->addError('success', "Le fichier theme-generator.json a été bien crée !");
    }

    public function delete_theme_file()
    {
        if ( ! is_dir($dir = $this->theme_generator_dir) ) {
            return $this->addError('danger', "Le dossier /theme-generator/ n'existe pas !");
        }

        # DELETE ASSETS FOLDER FROM PUBLIC FOLDER
        recursive_remove(public_path('assets'));

        if ( is_file($this->themeConfigFile) ) {
            unlink($this->themeConfigFile);
        }

        $this->themeConfigFileData = [];
        $this->disable_generate_btn__callback();

        return $this->addError('success', "Le fichier theme-generator.json a été néttoyé !");
    }


    public function render()
    {
        return view('livewire.installation-wizard.steps.theming');
    }
}
