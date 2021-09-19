<?php

use GustavoGama\MetatraderReportTransformer\Http\Controllers\PositionController;
use GustavoGama\MetatraderReportTransformer\Persistence\Repositories\PositionInterface;
use Psr\Container\ContainerInterface;

return [
    PositionController::class => static function (ContainerInterface $container): PositionController {
        return new PositionController(
            $container->get(PositionInterface::class)
        );
    },
];
