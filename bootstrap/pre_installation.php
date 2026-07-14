<?php

$basePath = dirname(__DIR__);
$envPath = $basePath . '/.env';
$examplePath = $basePath . '/.env.example';
$installedLock = $basePath . '/storage/app/installed.lock';

if (file_exists($installedLock)) {
    return;
}

$envWasCreated = false;

if (! file_exists($envPath)) {
    $created = file_exists($examplePath)
        ? @copy($examplePath, $envPath)
        : @file_put_contents($envPath, "APP_NAME=Laravel\nAPP_ENV=production\nAPP_KEY=\nAPP_DEBUG=false\nAPP_URL=http://localhost\n");

    if (! $created) {
        return;
    }

    $envWasCreated = true;
}

if (! is_readable($envPath) || ! is_writable($envPath)) {
    return;
}

$lines = file($envPath, FILE_IGNORE_NEW_LINES);

if ($lines === false) {
    return;
}

$env = [];
$hasInvalidEnvLines = false;

foreach ($lines as $line) {
    $trimmed = trim($line);

    if ($trimmed === '' || strpos($trimmed, '#') === 0) {
        continue;
    }

    if (strpos($line, '=') === false) {
        $hasInvalidEnvLines = true;
        continue;
    }

    [$key, $value] = explode('=', $line, 2);
    $env[trim($key)] = trim(trim($value), "\"'");
}

$scheme = (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? null;
$currentUrl = $host ? $scheme . '://' . $host : null;
$isLocalHost = ! $host || preg_match('/^(localhost|127\.0\.0\.1|\[::1\]|::1)(:\d+)?$/', $host);
$updates = [];

if (empty($env['APP_KEY'])) {
    $updates['APP_KEY'] = 'base64:' . base64_encode(random_bytes(32));
}

if (empty($env['APP_ENV']) || (! $isLocalHost && $env['APP_ENV'] === 'local')) {
    $updates['APP_ENV'] = 'production';
}

if (! isset($env['APP_DEBUG']) || $env['APP_DEBUG'] === '' || ! $isLocalHost) {
    $updates['APP_DEBUG'] = 'false';
}

if ($currentUrl && ($envWasCreated || empty($env['APP_URL']) || in_array($env['APP_URL'], ['http://localhost', 'http://127.0.0.1'], true))) {
    $updates['APP_URL'] = $currentUrl;
}

if (empty($updates) && ! $hasInvalidEnvLines) {
    return;
}

$writtenKeys = [];

foreach ($lines as $index => $line) {
    $trimmed = trim($line);

    if ($trimmed !== '' && strpos($trimmed, '#') !== 0 && strpos($line, '=') === false) {
        unset($lines[$index]);
        continue;
    }

    if ($trimmed === '' || strpos($trimmed, '#') === 0) {
        continue;
    }

    [$key] = explode('=', $line, 2);
    $key = trim($key);

    if (array_key_exists($key, $updates)) {
        $lines[$index] = $key . '=' . $updates[$key];
        $writtenKeys[$key] = true;
    }
}

foreach ($updates as $key => $value) {
    if (empty($writtenKeys[$key])) {
        $lines[] = $key . '=' . $value;
    }
}

@file_put_contents($envPath, implode(PHP_EOL, $lines) . PHP_EOL, LOCK_EX);
