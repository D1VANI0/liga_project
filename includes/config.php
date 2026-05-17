<?php
declare(strict_types=1);

<<<<<<< HEAD
function loadEnvironment(string $path): void
{
    if (!is_file($path)) {
=======
const PROJECT_ROOT = __DIR__ . '/..';

loadEnvFile(PROJECT_ROOT . '/.env');

function loadEnvFile(string $path): void
{
    if (!is_readable($path)) {
>>>>>>> 1c95d67abd59be267ccc96fde4b746c11bbb116b
        return;
    }

    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }

<<<<<<< HEAD
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
=======
        [$name, $value] = array_map('trim', explode('=', $line, 2));
        if ($name === '' || getenv($name) !== false) {
            continue;
        }

        $value = trim($value, "\"'");
        putenv($name . '=' . $value);
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
    }
}

function envValue(string $name, ?string $default = null): ?string
{
    $value = getenv($name);

    return $value === false || $value === '' ? $default : $value;
>>>>>>> 1c95d67abd59be267ccc96fde4b746c11bbb116b
}
