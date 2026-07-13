<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RecipientsCurrencyField extends Component
{
    public $currencies = [];


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($currencies)
    {
        $this->currencies = $currencies;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.recipients-currency-field');
    }
}
