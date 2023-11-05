<?php

namespace App\Filament\Widgets;

use App\Models\Request;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use App\Enums\OrderStatusEnum;

class RequestChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Request';

    protected function getData(): array
    {
        $data = Request::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Request created',
                    'data' => array_values($data)
                ]
            ],
            'labels' => OrderStatusEnum::cases()
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
