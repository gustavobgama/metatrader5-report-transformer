<?php declare(strict_types=1);

namespace GustavoGama\MetatraderReportTransformer\Persistence\Repositories;

use DateTime;
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
        //TODO: move the data transformation from here
        $this->model::updateOrCreate(
            [
                'id' => $position['Position']
            ],
            [
                'entry_time' => DateTime::createFromFormat('Y.m.d H:i:s', $position['Time'])->format('Y-m-d'),
                'symbol' => $position['Symbol'],
                'type' => $position['Type'],
                'volume' => $position['Volume'],
                'entry_price' => $position['Price'],
                'stop_loss' => $position['S / L'] ?: 0,
                'take_profit' => $position['T / P'] ?: 0,
                'exit_price' => $position['Price'],
                'commission' => $position['Commission'],
                'profit' => str_replace(' ', '', $position['Profit']),
            ]
        );
    }

    public function all(): array
    {
        return $this->model->all()->toArray();
    }
}
