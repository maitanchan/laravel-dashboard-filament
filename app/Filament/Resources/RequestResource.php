<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestResource\Pages;
use App\Models\Request;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;


class RequestResource extends Resource
{
    protected static ?string $model = Request::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Dịch vụ CSKH';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Yêu cầu khách hàng';

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
                                    ->label('Tên yêu cầu')
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
                                    ->unique(Request::class, 'slug', ignoreRecord: true),
                                Forms\Components\DatePicker::make('date_start')->required()->label('Ngày bắt đầu'),
                                Forms\Components\DatePicker::make('date_finish')->required()->label('Ngày kết thúc'),
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
                                Forms\Components\Toggle::make('status')->required()->label('Tình trạng')
                            ])->columns(1),



                        Forms\Components\Section::make('Associations')
                            ->schema([
                                Forms\Components\Select::make('customer_id')
                                    ->relationship('customer', 'name')
                                    ->searchable()
                                    ->required(),

                            ]),


                        Forms\Components\Section::make()
                            ->schema([

                                Forms\Components\FileUpload::make('image'),

                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Mã yêu cầu')->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')->label('Tên yêu cầu')->searchable()->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('desc')->label('Mô tả yêu cầu')->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('date_start')->label('Ngày yêu cầu')->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('date_finish')->label('Ngày hết hạn')->sortable()
                    ->toggleable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('customer.name')->label('Khách hàng')->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('status')->sortable()
                    ->toggleable()
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
                    Tables\Actions\DeleteAction::make()
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(null);
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
            'index' => Pages\ListRequests::route('/'),
            'create' => Pages\CreateRequest::route('/create'),
            'edit' => Pages\EditRequest::route('/{record}/edit'),
        ];
    }
}
