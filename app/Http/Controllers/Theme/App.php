<?php

namespace App\Http\Controllers\Theme;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class App extends Controller
{

    private $components = array(
        'bank-cards' => [
            'title' => 'Theme cartes bancaires',
            'component' => 'bank-cards',
            'description' => 'Mise en place des cartes bancaires.',
        ],
        'theming' => [
            'title' => 'Theming',
            'component' => 'theming',
            'description' => 'Mise en place du theme',
        ],
    );

    public function index(Request $request)
    {
        $indice     = $request->route('component');

        $index    = 'theming';
        if ( !empty($this->components[$indice]) ) {
            $index = $indice;
        }
        $component = $this->components[$index];

        unset($this->components[$index]);
        $links = $this->components;

        return view('pages.theme.index', compact('component', 'links'));
    }
}
