<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TransferNavPills extends Component
{

    public $step = 0;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($step)
    {
        $this->step = intval($step);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.transfer-nav-pills');
    }
}
