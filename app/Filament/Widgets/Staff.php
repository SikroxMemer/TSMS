<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Staff as StaffEntity;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class Staff extends ChartWidget
{
    protected static ?string $heading = 'Staff';

    protected function getData(): array
    {
        $data = Trend::model(StaffEntity::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

        // dd($data);

        return [
            'datasets' => [
                [
                    'label' => 'Staff',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}