<?php declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use DI\ContainerBuilder;
use Symfony\Component\Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;

$envFilePath = __DIR__ . '/.env';
if (is_readable($envFilePath)) {
    (new Dotenv())->usePutenv()->loadEnv($envFilePath);
}

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/config/datasource.php');
$builder->addDefinitions(__DIR__ . '/config/persistence.php');
$builder->addDefinitions(__DIR__ . '/config/database.php');
$builder->addDefinitions(__DIR__ . '/config/controller.php');
$container = $builder->build();

$capsule = $container->get(Capsule::class);
$capsule->setAsGlobal();
$capsule->bootEloquent();