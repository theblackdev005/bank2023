<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{

    public $imageUri;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($imageUri="common")
    {
        $nameimage = '/default/pages/' . strtolower($imageUri) . '.jpg';
        
        $this->imageUri = is_file( public_path('assets/images' . $nameimage) ) ? asset_img( $nameimage ) : null;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.breadcrumb');
    }
}
