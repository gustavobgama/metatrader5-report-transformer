<?php declare(strict_types=1);

namespace GustavoGama\MetatraderReportTransformer\DataTransformers;

interface DataTransformerInterface
{
    public function transform(array $data, float $balance): array;
}
