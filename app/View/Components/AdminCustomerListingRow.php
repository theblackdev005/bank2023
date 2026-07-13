<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminCustomerListingRow extends Component
{

    public $customer;
    public $languages;
    public $type;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($customer, $languages=[], $type=null)
    {
        $this->customer     = $customer;
        $this->languages    = $languages;
        $this->type         = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin-customer-listing-row');
    }
}
