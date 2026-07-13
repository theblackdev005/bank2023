<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Language;
use App\Models\Config;

class AdminUpdateLanguageForm extends Component
{

    public $languages;
    public $req_language;
    public $check_active = false;

    public function mount()
    {
        $this->initCy();
    }

    private function initCy() {
        $this->req_language = [];
        $this->languages   = Language::all();

        $this->check_active = Language::whereNotNull('enabled_at')->count() > 1;
    }

    public function makeUpdate()
    {
        try {
            
            foreach ($this->req_language as $id) {
                $check = Language::whereId($id)->firstOrFail();

                if ( $check->isEnabled() ) {
                    if ( Language::whereNotNull('enabled_at')->count() <= 1 ) {
                        continue;
                    }
                    $check->enabled_at = null;
                } else {
                    $check->enabled_at = now();
                }
                $check->saveOrFail();
            }

            # --------------------------------------------------------------
            # VERIFIER SI LA LANGUE PAR DEFAUT EST TOUJOURS ACTIF
            # --------------------------------------------------------------
            if ( ! Language::whereIso(DEFAULT_SITE_LANGUAGE)->firstOrFail()->isEnabled() ) {
                $lang = Language::whereNotNull('enabled_at')->firstOrFail();

                Config::whereName('DEFAULT_SITE_LANGUAGE')->update([
                    'value' => $lang->iso
                ]);
                Config::refreshCache();
            }
            $this->initCy();

            if ( ! Language::whereIso( app()->getLocale() )->firstOrFail()->isEnabled() ) {
                $lang = Language::whereNotNull('enabled_at')
                    ->orderByDesc('enabled_at')
                    ->first();

                app()->setLocale($lang->iso);

                return redirect( routeWithLocale('admin.manage_languages') );
            }

        } catch (\Exception $e) {
            dd( $e->getMessage() );
        }
    }

    public function render()
    {
        return view('livewire.admin-update-language-form');
    }
}
