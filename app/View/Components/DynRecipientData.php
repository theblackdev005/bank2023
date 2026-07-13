<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DynRecipientData extends Component
{
    public $transfert = [];
    public $code = null;
    public $showForm;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($data, $code=null, $showForm='yes')
    {
        $this->transfert = $data;
        $this->code = $code;
        $this->showForm = $showForm;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dyn-recipient-data');
    }
}
