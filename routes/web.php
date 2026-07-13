<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/src/theme.php';

Route::middleware('installation.checker')->group(function() {
    require __DIR__ . '/src/install.php';

    require __DIR__ . '/src/guest.php';
    require __DIR__ . '/src/customer.php';
    require __DIR__ . '/src/admin.php';
});
