<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormTextarea extends Component
{
    public $label = false;
    public $old = false;
    public $name = false;
    public $value = false;
    public $placeholder = false;
    public $wiremodel = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($value=null, $label=null, $name=null, $placeholder=null, $wiremodel=null)
    {
        $this->label            = $label;
        $this->old              = $name;
        $this->value            = $value;
        $this->placeholder      = $placeholder;
        $this->wiremodel        = $wiremodel;

        \formFieldNameMaker($this->name, $name);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-textarea');
    }
}
