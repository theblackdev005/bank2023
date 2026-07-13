<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminCard extends Component
{

    public $count;
    public $title;
    public $icon;
    public $url;
    public $options;
    public $description;

    public $alert_class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $icon, $url, $options="false", $count="false", $description=null, $theme=null)
    {
        $this->count            = $count;
        $this->title            = $title;
        $this->description      = $description;
        $this->icon             = $icon;
        $this->url              = filter_var($url, FILTER_VALIDATE_URL) 
            ? $url 
            : routeWithLocale($url);
        $this->options          = ($options === "true");

        if ( empty($theme) ) {
            if ( $options === 'false' ) {
                $this->alert_class = ($count > 0) ? "danger" : "success";
            } else {
                $this->alert_class = ($count > 0) ? "success" : "danger";
            }
        } else {
            $this->alert_class = $theme;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin-card');
    }
}
