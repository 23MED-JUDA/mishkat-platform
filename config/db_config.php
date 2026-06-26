<?php

define('APP_ROOT', dirname(__DIR__));

$envFile = APP_ROOT . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        if (str_contains($line, '=')) {
            [$key, $value] = explode('=', $line, 2);
            $key   = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }
    }
}

function detectEnvironment(): string
{
    $envVar = getenv('APP_ENV') ?: ($_ENV['APP_ENV'] ?? null);
    if ($envVar && in_array($envVar, ['local', 'staging', 'production'])) {
        return $envVar;
    }

    if (file_exists(APP_ROOT . '/.env.local')) {
        return 'local';
    }

    $host = $_SERVER['HTTP_HOST'] ?? gethostname() ?? '';
    $localPatterns = ['localhost', '127.0.0.1', '::1', '.local', '.test', '.dev'];
    foreach ($localPatterns as $pattern) {
        if (str_contains($host, $pattern)) {
            return 'local';
        }
    }

    if (PHP_SAPI === 'cli' && !$envVar) {
        return 'local';
    }

    return 'production';
}

$environments = [
    'local' => [
        'db' => [
            'host'    => getenv('DB_HOST') ?: '127.0.0.1',
            'port'    => (int)(getenv('DB_PORT') ?: 3306),
            'name'    => getenv('DB_NAME') ?: 'mishkat_db',
            'user'    => getenv('DB_USER') ?: 'root',
            'pass'    => getenv('DB_PASS') ?: '',
            'charset' => 'utf8mb4',
        ],
        'app' => [
            'debug'     => true,
            'log_level' => 'debug',
            'base_url'  => 'http://localhost',
        ],
    ],
    'staging' => [
        'db' => [
            'host'    => getenv('DB_HOST') ?: 'staging-db.mishkat.com',
            'port'    => (int)(getenv('DB_PORT') ?: 3306),
            'name'    => getenv('DB_NAME') ?: 'mishkat_staging',
            'user'    => getenv('DB_USER') ?: 'mishkat_stage',
            'pass'    => getenv('DB_PASS') ?: '',
            'charset' => 'utf8mb4',
        ],
        'app' => [
            'debug'     => true,
            'log_level' => 'warning',
            'base_url'  => 'https://staging.mishkat.com',
        ],
    ],
    'production' => [
        'db' => [
            'host'    => getenv('DB_HOST') ?: 'db.mishkat.com',
            'port'    => (int)(getenv('DB_PORT') ?: 3306),
            'name'    => getenv('DB_NAME') ?: 'mishkat_db',
            'user'    => getenv('DB_USER') ?: 'mishkat_user',
            'pass'    => getenv('DB_PASS') ?: '',
            'charset' => 'utf8mb4',
        ],
        'app' => [
            'debug'     => false,
            'log_level' => 'error',
            'base_url'  => 'https://mishkat.com',
        ],
    ],
];

define('APP_ENV', detectEnvironment());

if (!isset($environments[APP_ENV])) {
    die('[db_config] بيئة غير معروفة: ' . APP_ENV);
}

$config = $environments[APP_ENV];

function config(string $key, mixed $default = null): mixed
{
    global $config;
    $parts   = explode('.', $key);
    $current = $config;
    foreach ($parts as $part) {
        if (!is_array($current) || !array_key_exists($part, $current)) {
            return $default;
        }
        $current = $current[$part];
    }
    return $current;
}

function dbConfig(): array
{
    return config('db', []);
}

function isProduction(): bool { return APP_ENV === 'production'; }
function isLocal(): bool { return APP_ENV === 'local'; }
function isStaging(): bool { return APP_ENV === 'staging'; }
function isDebug(): bool { return (bool) config('app.debug', false); }

