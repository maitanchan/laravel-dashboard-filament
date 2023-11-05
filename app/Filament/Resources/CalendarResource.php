<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CalendarResource\Pages;
use App\Models\Calendar;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;


class CalendarResource extends Resource
{
    protected static ?string $model = Calendar::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Dịch vụ CSKH';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Lịch hẹn';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Tên lịch hẹn')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                        if ($operation !== 'create') {
                                            return;
                                        }
                                        $set('slug', Str::slug($state));
                                    }),
                                Forms\Components\TextInput::make('slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(Calendar::class, 'slug', ignoreRecord: true),
                                Forms\Components\DatePicker::make('time')->required()->label('Thời gian thực hiện'),
                                Forms\Components\RichEditor::make('desc')
                                    ->label('Mô tả chi tiết')
                                    ->required()
                                    ->columnSpan('full')

                            ])->columns(2),

                    ]),

                Forms\Components\Group::make()
                    ->schema([

                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Toggle::make('status')->required()->label('Trạng thái')
                            ])->columns(1),



                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('customer_id')
                                    ->relationship('customer', 'name')
                                    ->required()
                                    ->searchable()
                                    ->label('Khách hàng'),

                            ]),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Mã lịch hẹn')
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Tên lịch hẹn')->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('desc')->label('Nội dung')
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time')->label('Thời gian thực hiện')->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')->label('Khách hàng')->toggleable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->toggleable()
                    ->label('Trạng thái')
                    ->boolean(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCalendars::route('/'),
            'create' => Pages\CreateCalendar::route('/create'),
            'edit' => Pages\EditCalendar::route('/{record}/edit'),
        ];
    }
}
