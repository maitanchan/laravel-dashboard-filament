<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Quản lý';

    protected static ?string $navigationLabel = 'Thương hiệu';

    protected static ?string $recordTitleAttribute = 'name';


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
                        Forms\Components\Section::make([

                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->live(onBlur: true)
                                ->label('Tên thương hiệu')
                                ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                    if ($operation !== 'create') {
                                        return;
                                    }

                                    $set('slug', Str::slug($state));
                                }),

                            Forms\Components\TextInput::make('slug')
                                ->disabled()
                                ->dehydrated()
                                ->required(),

                            Forms\Components\TextInput::make('url')
                                ->label('Website URL')
                                ->required()
                                ->columnSpan('full'),

                            Forms\Components\RichEditor::make('description')
                                ->columnSpan('full')
                                ->label('Mô tả')

                        ])->columns(2)
                    ]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status')
                            ->schema([
                                Forms\Components\Toggle::make('is_visible')
                                    ->label('Hiển thị')
                                    ->helperText('Enable or disable brand visibility')
                                    ->default(true),
                            ]),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Color')
                                    ->schema([
                                        Forms\Components\ColorPicker::make('primary_hex')
                                            ->label('Primary Color')
                                    ])
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Tên thương hiệu')
                    ->toggleable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('url')
                    ->label('Website URL')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\ColorColumn::make('primary_hex')
                    ->label('Primary Color'),

                Tables\Columns\IconColumn::make('is_visible')
                    ->boolean()
                    ->sortable()
                    ->toggleable()
                    ->label('Hiển thị'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->date()
                    ->sortable()
                    ->toggleable()
                    ->label('Ngày sửa'),
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
