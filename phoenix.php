<?php

use Symfony\Component\Dotenv\Dotenv;

$envFilePath = __DIR__ . '/.env';
if (is_readable($envFilePath)) {
    (new Dotenv())->usePutenv()->loadEnv($envFilePath);
}

return [
    'log_table_name' => 'migrations',
    'migration_dirs' => [
        'first' => __DIR__ . '/database/migrations',
    ],
    'environments' => [
        'local' => [
            'adapter' => getenv('DB_DRIVER'),
            'db_name' => getenv('DB_DATABASE'),
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8',
        ],
    ],
    'default_environment ' => 'local',
];