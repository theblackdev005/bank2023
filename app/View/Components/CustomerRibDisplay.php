<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CustomerRibDisplay extends Component
{

    public $rib;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($rib)
    {
        $this->rib = $rib;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.customer-rib-display');
    }
}
