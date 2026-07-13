<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Country;

class AdminUpdateCountryForm extends Component
{

    public $countries;
    public $req_country;

    public function mount()
    {
        $this->initCy();
    }

    private function initCy() {
        $this->req_country = [];
        $this->countries   = Country::all();
    }

    public function makeUpdate()
    {
        try {
            
            foreach ($this->req_country as $id) {
                $check = Country::whereId($id)->firstOrFail();
                if ( $check->isEnabled() ) {
                    $check->enabled_at = null;
                } else {
                    $check->enabled_at = now();
                }
                $check->saveOrFail();
            }
            
        } catch (\Exception $e) {
            
        }

        $this->initCy();
    }

    public function render()
    {
        return view('livewire.admin-update-country-form');
    }
}
