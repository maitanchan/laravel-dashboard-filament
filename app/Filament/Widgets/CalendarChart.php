<?php

namespace App\Filament\Widgets;

use App\Models\Calendar;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CalendarChart extends ChartWidget
{
    protected static ?int $sort = 4;

    protected static ?string $heading = 'Calendar';

    protected function getData(): array
    {
        $data = Calendar::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Lịch hẹn được tạo',
                    'data' => array_values($data)
                ]
            ]
        ];
    }


    protected function getType(): string
    {
        return 'doughnut';
    }
}
