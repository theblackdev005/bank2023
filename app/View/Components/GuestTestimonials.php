<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GuestTestimonials extends Component
{

    public $testimonials = [];
    public $show_pagination = 'true';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($items, $pagination='true')
    {
        $this->testimonials = $items;
        $this->show_pagination = $pagination;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.guest-testimonials');
    }
}
