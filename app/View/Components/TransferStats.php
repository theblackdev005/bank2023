<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TransferStats extends Component
{
    public $pending_transfert = [];
    public $init;
    public $percentage = 0;
    public $showNextPendingFee;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($data, $percentage, $init="no", $showNextPendingFee="yes")
    {
        $this->pending_transfert = $data;
        $this->percentage = floatval($percentage);
        $this->init = $init;
        $this->showNextPendingFee = $showNextPendingFee;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.transfer-stats');
    }
}
