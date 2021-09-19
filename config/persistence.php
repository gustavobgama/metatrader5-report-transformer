<?php

use GustavoGama\MetatraderReportTransformer\Persistence\Models\Position as PositionModel;
use GustavoGama\MetatraderReportTransformer\Persistence\Repositories\Position;
use GustavoGama\MetatraderReportTransformer\Persistence\Repositories\PositionInterface;
use Psr\Container\ContainerInterface;

return [
    PositionInterface::class => static function (ContainerInterface $container): Position {
        return new Position(new PositionModel());
    },
];
