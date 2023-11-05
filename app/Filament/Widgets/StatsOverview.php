<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatusEnum;
use App\Models\Calendar;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Request;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = '15s';

    protected static bool $isLazy = true;
    protected function getStats(): array
    {
        return [
            Stat::make('Người dùng', Customer::count())
                ->description('Tăng')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('Yêu cầu khách hàng', Request::count())
                ->description('Tăng')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            Stat::make('Lịch hẹn', Calendar::count())
                ->description('Giảm')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            Stat::make('Sản phẩm', Product::count())
                ->description('Tổng hàng trong kho')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),


        ];
    }
}
