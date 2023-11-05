<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\RequestResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestRequest extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(RequestResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Mã yêu cầu'),
                Tables\Columns\TextColumn::make('name')->label('Tên yêu cầu'),
                Tables\Columns\TextColumn::make('desc')->label('Mô tả yêu cầu'),
                Tables\Columns\TextColumn::make('date_start')->label('Ngày yêu cầu'),
                Tables\Columns\TextColumn::make('date_finish')->label('Ngày hết hạn'),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('customer.name')->label('Khách hàng'),
                Tables\Columns\IconColumn::make('status')
                    ->toggleable()
                    ->label('Trạng thái')
                    ->boolean(),
            ]);
    }
}
