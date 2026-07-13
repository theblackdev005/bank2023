<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TransferMoreInformations extends Component
{

    public $fee;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($fee=[])
    {
        $this->fee = $fee;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.transfer-more-informations');
    }
}
