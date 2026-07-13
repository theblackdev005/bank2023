<?php

use App\Http\Controllers\Theme\App;

Route::middleware(['valid.language'])->prefix('/{language}/theme')->group(function () {
    Route::get('/{component?}', [App::class, 'index'])->name('theme.index');
});