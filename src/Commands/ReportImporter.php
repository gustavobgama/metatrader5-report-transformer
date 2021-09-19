<?php declare(strict_types=1);

namespace GustavoGama\MetatraderReportTransformer\Commands;

use GustavoGama\MetatraderReportTransformer\DataSources\DataSourceInterface;
use GustavoGama\MetatraderReportTransformer\Persistence\Repositories\Position;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReportImporter extends Command
{
    protected static $defaultName = 'report:import';
    private DataSourceInterface $dataSource;
    private Position $repository;

    public function configure()
    {
        $this->setDescription('Import the html reports, transform and store its data');
    }

    public function __construct(
        DataSourceInterface $dataSource,
        Position $repository
    ) {
        $this->dataSource = $dataSource;
        $this->repository = $repository;

        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $positions = $this->dataSource->getPositions();
        foreach ($positions as $position) {
            $this->repository->save($position);
        }

        return Command::SUCCESS;
    }
}