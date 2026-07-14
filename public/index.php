<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$installedLock = __DIR__.'/../storage/app/installed.lock';
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';

if (file_exists($installedLock) && (
    $requestPath === '/installation' ||
    strpos($requestPath, '/livewire/message/installation-wizard') === 0
)) {
    http_response_code(404);
    exit('Not Found');
}

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

if (file_exists($preInstallation = __DIR__.'/../bootstrap/pre_installation.php')) {
    require $preInstallation;
}

$environmentFile = __DIR__.'/../.env';
$environmentContent = is_readable($environmentFile) ? file_get_contents($environmentFile) : false;
$hasApplicationKey = is_string($environmentContent)
    && preg_match('/^APP_KEY\s*=\s*[^\s]+/m', $environmentContent);

if (! file_exists($installedLock) && (! is_file($environmentFile) || ! $hasApplicationKey)) {
    http_response_code(500);
    exit('Installation impossible : le fichier .env n\'a pas pu être préparé. Vérifiez les permissions du dossier du projet et du fichier .env.');
}

if (file_exists($installedLock) && (! is_file($environmentFile) || ! $hasApplicationKey)) {
    http_response_code(500);
    exit('Configuration indisponible : le fichier .env ou APP_KEY est absent. Restaurez votre sauvegarde sans relancer l\'installation.');
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
