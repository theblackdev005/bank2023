<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormPhoneInput extends Component
{

    public $label = false;
    public $old = false;
    public $value = false;
    public $name = false;
    public $placeholder = false;
    public $optional = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($value=null, $label=null, $name=null, $placeholder=null, $optional=false)
    {
        $this->label            = $label;
        $this->old              = $name;
        $this->placeholder      = $placeholder;
        $this->value            = $value;
        $this->optional         = $optional;

        \formFieldNameMaker($this->name, $name);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-phone-input');
    }
}
