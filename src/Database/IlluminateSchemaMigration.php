<?php declare(strict_types=1);

namespace GustavoGama\MetatraderReportTransformer\Database;

use Phoenix\Database\Adapter\AdapterInterface;
use Phoenix\Migration\AbstractMigration;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Builder;
use Symfony\Component\Dotenv\Dotenv;

abstract class IlluminateSchemaMigration extends AbstractMigration
{
    protected Builder $schema;

    public function __construct(AdapterInterface $adapter)
    {
        $this->loadEnvs();
        $this->loadSchemaMigration();

        parent::__construct($adapter);
    }

    private function loadEnvs(): void
    {
        $envFilePath = __DIR__ . '/../../.env';
        if (is_readable($envFilePath)) {
            (new Dotenv())->usePutenv()->loadEnv($envFilePath);
        }
    }

    private function loadSchemaMigration(): void
    {
        // TODO: find a better way to retrieve this class
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
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        $this->schema = $capsule->schema();
    }
}
