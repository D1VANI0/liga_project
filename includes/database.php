<?php
declare(strict_types=1);

function db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $config = databaseConfig();
    $pdo = new PDO($config['dsn'], $config['user'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => true,
    ]);

    return $pdo;
}

function databaseConfig(): array
{
    $dsn = envValue('SUPABASE_DB_DSN');
    $user = envValue('SUPABASE_DB_USER');
    $password = envValue('SUPABASE_DB_PASSWORD');

    if ($dsn !== null && $user !== null && $password !== null) {
        return [
            'dsn' => $dsn,
            'user' => $user,
            'password' => $password,
        ];
    }

    $url = envValue('DATABASE_URL');
    if ($url !== null) {
        return databaseConfigFromUrl($url);
    }

    throw new RuntimeException('Brak konfiguracji bazy danych. Ustaw SUPABASE_DB_DSN, SUPABASE_DB_USER i SUPABASE_DB_PASSWORD albo DATABASE_URL.');
}

function databaseConfigFromUrl(string $url): array
{
    $parts = parse_url($url);
    if ($parts === false || !isset($parts['host'], $parts['user'])) {
        throw new RuntimeException('Nieprawidłowy DATABASE_URL.');
    }

    $scheme = $parts['scheme'] ?? '';
    if (!in_array($scheme, ['postgres', 'postgresql'], true)) {
        throw new RuntimeException('DATABASE_URL musi wskazywać na PostgreSQL.');
    }

    $host = $parts['host'];
    $port = (int) ($parts['port'] ?? 5432);
    $database = isset($parts['path']) ? ltrim($parts['path'], '/') : 'postgres';
    $database = $database !== '' ? $database : 'postgres';

    return [
        'dsn' => sprintf('pgsql:host=%s;port=%d;dbname=%s;sslmode=require', $host, $port, $database),
        'user' => rawurldecode($parts['user']),
        'password' => rawurldecode($parts['pass'] ?? ''),
    ];
}

function dbRows(string $sql, array $params = []): array
{
    $statement = db()->prepare($sql);
    dbBindValues($statement, $params);
    $statement->execute();

    return $statement->fetchAll();
}

function dbRow(string $sql, array $params = []): ?array
{
    $statement = db()->prepare($sql);
    dbBindValues($statement, $params);
    $statement->execute();
    $row = $statement->fetch();

    return is_array($row) ? $row : null;
}

function dbExecute(string $sql, array $params = []): void
{
    $statement = db()->prepare($sql);
    dbBindValues($statement, $params);
    $statement->execute();
}

function dbBindValues(PDOStatement $statement, array $params): void
{
    foreach ($params as $name => $value) {
        $parameter = is_int($name) ? $name + 1 : ':' . $name;
        $type = match (true) {
            $value === null => PDO::PARAM_NULL,
            is_int($value) => PDO::PARAM_INT,
            is_bool($value) => PDO::PARAM_BOOL,
            default => PDO::PARAM_STR,
        };

        $statement->bindValue($parameter, $value, $type);
    }
}
