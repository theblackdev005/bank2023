<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RecipientsCountryField extends Component
{

    public $countries = [];


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($countries)
    {
        $this->countries = $countries;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.recipients-country-field');
    }
}
