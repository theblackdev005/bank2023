<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminCustomSwitch extends Component
{

    public $checked;
    public $input_name;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($checked, $name='enable')
    {
        $this->checked = ( $checked == '1' );

        \formFieldNameMaker($this->input_name, $name);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin-custom-switch');
    }
}
