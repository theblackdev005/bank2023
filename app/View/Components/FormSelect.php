<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormSelect extends Component
{

    public $options;
    public $optionLabelKey;
    public $optionValueKey;
    public $selectLabel;
    public $selectName;
    public $defaultValue;
    public $callback;
    public $wiremodel;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($options, $selectLabel, $name, $optionLabelKey=null, $optionValueKey=null, $defaultValue=null, $callback=null, $wiremodel=null) {
        $this->options          = $options;
        
        $this->optionLabelKey   = $optionLabelKey; 
        $this->optionValueKey   = $optionValueKey;
        $this->selectLabel      = $selectLabel;

        $this->defaultValue     = !empty($defaultValue) ? $defaultValue : old($name);
        $this->callback         = $callback;
        $this->wiremodel        = $wiremodel;

        // ----------------------------------------------
        \formFieldNameMaker($this->selectName, $name);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-select');
    }
}
