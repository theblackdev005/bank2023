<?php

namespace App\Http\Livewire\InstallationWizard;

use Livewire\Component;


define('FOLDER_CHMOD', 755 );


class Requirements extends Component
{

    public $requirements = [];
    private $requiredExtensions = [
        'Ctype',
        'cURL',
        'DOM',
        'Fileinfo',
        'Filter',
        'Hash',
        'Mbstring',
        'OpenSSL',
        'PCRE',
        'PDO',
        'Session',
        'Tokenizer',
        'XML',
    ];

    private $folders = array(
        'storage/framework',
        'storage/logs',
        'bootstrap/cache'
    );

    protected $listeners = array(
        'checkStepOnChild',
    );

    public function checkStepOnChild() {
        $this->emitUp('goNextListener');
    }

    public function init($refresh_title=true)
    {
        $disabled = false;

        foreach ($this->requirements as $requirement) {
            if ( ! $requirement['compatibility'] ) {
                $disabled = true;
                break;
            }
        }
        $this->emitUp('disableNextbtnListener', $disabled);

        if ( $refresh_title ) {
            $this->emitUp('changeTitleListener', 'Requirements');
        }
    }
    

    public function mount()
    {
        # CHECK FOLDER REQUIREMENTS
        $this->check_folder_requirements();

        # CHECK EXTENSION REQUIREMENTS
        $this->check_extension_requirements();
    }

    private function check_extension_requirements() {
        $this->requirements['Version PHP'] = [
            'value'         => PHP_VERSION,
            'compatibility' => version_compare(PHP_VERSION, '7.3.0', '>='),
            'need_action'   => false,
        ];

        array_map(function ($extension) {
            if ( ! $isLoaded = extension_loaded($extension) ) {
                $this->requirements[ucfirst($extension)] = [
                    'value'         => null,
                    'compatibility' => $isLoaded,
                    'need_action'   => false
                ];
            }
        }, $this->requiredExtensions);
    }

    private function check_folder_requirements($test=false)
    {
        foreach ($this->folders as $folder) {
            $chmod = substr(sprintf('%o', fileperms(base_path($folder))), -3);
            
            $compatibleChmod = ($chmod >= FOLDER_CHMOD);

            $this->requirements[$folder] = [
                'value'         => $chmod,
                'compatibility' => $compatibleChmod,
                'need_action'   => !$compatibleChmod,
            ];
        }
    }

    public function set_requirement($folder)
    {
        if ( chmod( base_path($folder), FOLDER_CHMOD) ) {
            $this->requirements[$folder] = [
                'value'         => FOLDER_CHMOD,
                'compatibility' => true,
                'need_action'   => false,
            ];

            # CHECK FOLDER REQUIREMENTS
            $this->check_folder_requirements();
            
            # EMIT VARIABLE TO PARENT
            $this->init( false );
        }
    }

    public function render()
    {
        return view("livewire.installation-wizard.steps.requirements");
    }
}
