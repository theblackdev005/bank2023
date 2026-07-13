<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Currency;

class AdminUpdateCurrencyForm extends Component
{

    public $currencies;
    public $req_currency;

    public function mount()
    {
        $this->initCy();
    }

    private function initCy() {
        $this->req_currency = [];
        $this->currencies   = Currency::all();
    }

    public function makeUpdate()
    {
        try {
            
            foreach ($this->req_currency as $id) {
                $check = Currency::whereId($id)->firstOrFail();
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
        return view('livewire.admin-update-currency-form');
    }
}
