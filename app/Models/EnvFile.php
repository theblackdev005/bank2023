<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use RuntimeException;

class EnvFile extends Model
{
    private const RAW_LINE_PREFIX = '__ENV_RAW_LINE__';

    public static function parse()
    {
        $path = app()->environmentFilePath();

        if (! is_file($path) || ! is_readable($path)) {
            return [];
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES);

        if ($lines === false) {
            throw new RuntimeException("Impossible de lire le fichier .env.");
        }

        $content = [];

        foreach ($lines as $index => $line) {
            $trimmed = trim($line);

            if ($trimmed === '' || strpos($trimmed, '#') === 0 || strpos($line, '=') === false) {
                $content[self::RAW_LINE_PREFIX . $index] = $line;
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $content[trim($key)] = self::decodeValue($value);
        }

        return $content;
    }

    public static function get($prefix)
    {
        $data = [];

        foreach (self::parse() as $key => $value) {
            if (strpos((string) $key, $prefix) === 0) {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    public static function set(array $posts)
    {
        return array_replace(self::parse(), $posts);
    }

    public static function regenerate(array $posts, $preserveCriticalValues = true)
    {
        if ($preserveCriticalValues) {
            $posts = self::preserveCriticalValues($posts);
        }

        $path = app()->environmentFilePath();
        $directory = dirname($path);

        if (! is_dir($directory) || ! is_writable($directory) || (is_file($path) && ! is_writable($path))) {
            throw new RuntimeException("Le fichier .env doit être accessible en écriture.");
        }

        self::backupEnvironmentFile();

        $lines = [];

        foreach ($posts as $key => $value) {
            if (strpos((string) $key, self::RAW_LINE_PREFIX) === 0) {
                $lines[] = (string) $value;
                continue;
            }

            $lines[] = $key . '=' . self::encodeValue($value);
        }

        $temporaryPath = $path . '.tmp';
        $content = implode(PHP_EOL, $lines) . PHP_EOL;

        if (file_put_contents($temporaryPath, $content, LOCK_EX) === false || ! @rename($temporaryPath, $path)) {
            @unlink($temporaryPath);
            throw new RuntimeException("Impossible d'enregistrer le fichier .env.");
        }

        Artisan::call('cache:clear');
        Artisan::call('config:clear');

        return true;
    }

    private static function preserveCriticalValues(array $posts)
    {
        $current = self::parse();

        foreach ([
            'APP_KEY',
            'DB_CONNECTION',
            'DB_HOST',
            'DB_PORT',
            'DB_DATABASE',
            'DB_USERNAME',
            'DB_PASSWORD',
        ] as $key) {
            $incomingIsEmpty = ! array_key_exists($key, $posts) || $posts[$key] === null || $posts[$key] === '';

            if ($incomingIsEmpty && isset($current[$key]) && $current[$key] !== '') {
                $posts[$key] = $current[$key];
            }
        }

        return $posts;
    }

    private static function backupEnvironmentFile()
    {
        $path = app()->environmentFilePath();

        if (! is_file($path)) {
            return;
        }

        $backupDirectory = storage_path('app/env-backups');

        if (! is_dir($backupDirectory) && ! @mkdir($backupDirectory, 0755, true) && ! is_dir($backupDirectory)) {
            return;
        }

        @copy($path, $backupDirectory . '/.env-' . date('YmdHis') . '-' . uniqid());
    }

    private static function decodeValue($value)
    {
        $value = trim((string) $value);

        if (strlen($value) >= 2 && $value[0] === '"' && substr($value, -1) === '"') {
            return str_replace(['\\"', '\\\\'], ['"', '\\'], substr($value, 1, -1));
        }

        if (strlen($value) >= 2 && $value[0] === "'" && substr($value, -1) === "'") {
            return substr($value, 1, -1);
        }

        return $value;
    }

    private static function encodeValue($value)
    {
        $value = (string) ($value ?? '');

        if ($value === '') {
            return '';
        }

        if (preg_match('/\s|#|=|"|^[$\{]/', $value)) {
            return '"' . str_replace(['\\', '"'], ['\\\\', '\\"'], $value) . '"';
        }

        return $value;
    }
}
