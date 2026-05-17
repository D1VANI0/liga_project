<?php
declare(strict_types=1);

function loadEnvironment(string $path): void
{
    if (!is_file($path)) {
        return;
    }

    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }

        [$name, $value] = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value, " \t\n\r\0\x0B\"'");

        if ($name !== '' && getenv($name) === false) {
            putenv($name . '=' . $value);
            $_ENV[$name] = $value;
        }
    }
}

function appConfig(string $key, ?string $default = null): ?string
{
    static $loaded = false;

    if (!$loaded) {
        loadEnvironment(__DIR__ . '/../.env');
        $loaded = true;
    }

    $value = getenv($key);

    return $value === false ? $default : $value;
}
