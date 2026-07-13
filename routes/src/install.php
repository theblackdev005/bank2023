<?php

use App\Http\Livewire\InstallationWizard\Install;


Route::get('/installation', Install::class)->name('install.start');