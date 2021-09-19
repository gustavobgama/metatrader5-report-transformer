<?php declare(strict_types=1);

namespace GustavoGama\MetatraderReportTransformer\Persistence\Repositories;

interface PositionInterface
{
    public function save(array $position): void;

    public function all(): array;
}
