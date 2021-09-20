<?php declare(strict_types=1);

namespace GustavoGama\MetatraderReportTransformer\DataTransformers;

use DateTime;

class PositionTransformer implements DataTransformerInterface
{
    public function transform(array $position, float $balance): array
    {
        $points = $this->calculatePoints($position);
        $profit = str_replace(' ', '', $position['Profit']);

        return [
            'id' => $position['Position'],
            'date' => DateTime::createFromFormat('Y.m.d H:i:s', $position['Time'])->format('Y-m-d'),
            'symbol' => $position['Symbol'],
            'type' => $position['Type'],
            'volume' => $position['Volume'],
            'points' => $points,
            'commission' => $this->calculateCommission($position),
            'is_gain' => $points > 0,
            'profit' => $profit,
            'balance' => $balance + $profit,
        ];
    }

    private function calculatePoints(array $position): float
    {
        if ($position['Type'] === 'buy') {
            return $position['Price_1'] - $position['Price'];
        }

        return $position['Price'] - $position['Price_1'];
    }

    private function calculateCommission(array $position): float
    {
        // TODO: calculate commission
        return (float) $position['Commission'];
    }
}
