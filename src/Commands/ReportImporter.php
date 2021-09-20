<?php declare(strict_types=1);

namespace GustavoGama\MetatraderReportTransformer\Commands;

use GustavoGama\MetatraderReportTransformer\DataSources\DataSourceInterface;
use GustavoGama\MetatraderReportTransformer\DataTransformers\DataTransformerInterface;
use GustavoGama\MetatraderReportTransformer\Persistence\Repositories\Position;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReportImporter extends Command
{
    protected static $defaultName = 'report:import';
    private DataSourceInterface $dataSource;
    private DataTransformerInterface $dataTransformer;
    private Position $repository;

    public function configure()
    {
        $this->setDescription('Import the html reports, transform and store its data');
    }

    public function __construct(
        DataSourceInterface $dataSource,
        DataTransformerInterface $dataTransformer,
        Position $repository
    ) {
        $this->dataSource = $dataSource;
        $this->dataTransformer = $dataTransformer;
        $this->repository = $repository;

        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $positions = $this->dataSource->getPositions();
        $balance = 5000;
        foreach ($positions as $position) {
            // TODO: move filter rules to other class
            if (strpos($position['Symbol'], 'WIN') === false) {
                continue;
            }
            $position = $this->dataTransformer->transform($position, $balance);
            $this->repository->save($position);
            $balance = $position['balance'];
        }

        return Command::SUCCESS;
    }
}