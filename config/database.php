<?php

use Psr\Container\ContainerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

return [
    Capsule::class => static function (ContainerInterface $container): Capsule {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
        ]);

        return $capsule;
    },
];
