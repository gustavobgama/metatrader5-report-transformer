<?php declare(strict_types=1);

namespace GustavoGama\MetatraderReportTransformer\Persistence\Repositories;

use GustavoGama\MetatraderReportTransformer\Persistence\Models\Position as Model;

class Position implements PositionInterface
{
    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function save(array $position): void
    {
        $this->model::updateOrCreate(
            [
                'id' => $position['id']
            ],
            $position
        );
    }

    public function all(): array
    {
        return $this->model->all()->toArray();
    }
}
