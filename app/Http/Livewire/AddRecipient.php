<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Country;

class AddRecipient extends Component
{
    public $currentForm = 'default';
    public $countries;
    public $currencies;

    public $selected_country;
    public $selected_country_data;
    public $ihave = 'iban_swift';

    public $show_country_loader = false;

    private $POSSIBLE_COUNTRIES = ['AU', 'CA', 'GB', 'NZ', 'US'];

    public function mount($countries, $currencies)
    {
        $this->countries = $countries;
        $this->currencies = $currencies;
    }

    public function updating()
    {
        $this->show_country_loader = true;
    }

    public function updated()
    {
        $this->show_country_loader = true;
        $this->selected_country_data = Country::whereId($this->selected_country)->first();
        
        $this->currentForm = 'default';
        if ( $this->selected_country_data ) {
            if ( in_array($this->selected_country_data->iso, $this->POSSIBLE_COUNTRIES) ) {
                $this->currentForm = $this->selected_country_data->iso;
            }
        }
        $this->show_country_loader = false;
    }

    public function render()
    {
        return view('livewire.add-recipient');
    }
}
