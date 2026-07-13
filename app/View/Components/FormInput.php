<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormInput extends Component
{

    public $addons = false;
    public $step = false;

    public $label = false;
    public $type = false;
    public $old = false;
    public $value = false;
    public $name = false;
    public $placeholder = false;
    public $optional = false;
    public $wiremodel = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($value=null, $step=null, $addons=null, $label=null, $type=null, $name=null, $placeholder=null, $optional=false, $wiremodel=false)
    {
        $this->label            = $label;
        $this->type             = $type;
        $this->old              = $name;
        $this->placeholder      = $placeholder;
        $this->addons           = $addons;
        $this->step             = $step;
        $this->value            = $value;
        $this->optional         = $optional;
        $this->wiremodel         = $wiremodel;

        if ( empty($this->step) && $type == 'number' ) {
            $this->step = 0.01;
        }

        \formFieldNameMaker($this->name, $name);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-input');
    }
}
