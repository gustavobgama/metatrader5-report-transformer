<?php declare(strict_types=1);

namespace GustavoGama\MetatraderReportTransformer\DataSources;

interface DataSourceInterface
{
    public function getPositions(): array;
}
