<?php

use GustavoGama\MetatraderReportTransformer\DataSources\DataSourceInterface;
use GustavoGama\MetatraderReportTransformer\DataSources\HtmlDataSource;
use Psr\Container\ContainerInterface;
use Symfony\Component\DomCrawler\Crawler;

return [
    DataSourceInterface::class => static function (ContainerInterface $container): HtmlDataSource {
        return new HtmlDataSource(
            new Crawler(),
            getenv('IMPORTER_FILE_PATH')
        );
    },
];
