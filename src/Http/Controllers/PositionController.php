<?php declare(strict_types=1);

namespace GustavoGama\MetatraderReportTransformer\Http\Controllers;

use GustavoGama\MetatraderReportTransformer\Persistence\Repositories\PositionInterface;
use Psr\Http\Message\ServerRequestInterface;

class PositionController
{
    private PositionInterface $position;

    public function __construct(PositionInterface $position)
    {
        $this->position = $position;
    }

    public function __invoke(ServerRequestInterface $request): array
    {
        return $this->position->all();
    }
}
