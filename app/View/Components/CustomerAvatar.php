<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CustomerAvatar extends Component
{

    public $src = null;
    public $size = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($src, $size=null)
    {
        $this->src = $src;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.customer-avatar');
    }
}
