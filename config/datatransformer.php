<?php

use GustavoGama\MetatraderReportTransformer\DataTransformers\DataTransformerInterface;
use GustavoGama\MetatraderReportTransformer\DataTransformers\PositionTransformer;
use Psr\Container\ContainerInterface;

return [
    DataTransformerInterface::class => static function (ContainerInterface $container): PositionTransformer {
        return new PositionTransformer();
    },
];
