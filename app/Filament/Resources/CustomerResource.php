<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Quản lý';

    protected static ?string $navigationLabel = 'Khách hàng';


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
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Họ tên')
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
                                    ->unique(Customer::class, 'slug', ignoreRecord: true),

                                Forms\Components\TextInput::make('phone')
                                    ->label('Số điện thoại')
                                    ->required(),
                                Forms\Components\RichEditor::make('desc')
                                    ->label('Ghi chú')
                                    ->required()
                                    ->columnSpan('full')
                            ])->columns(2),
                        Forms\Components\Section::make()
                            ->schema([

                                Forms\Components\TextInput::make('social')->required()->label('Mạng xã hội'),
                                Forms\Components\TextInput::make('email')->required(),


                            ]),
                    ]),

                Forms\Components\Group::make()
                    ->schema([

                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('gender')->required()->label('Giới tính')
                                    ->options([
                                        'nam' => 'Nam',
                                        'nu' => 'Nữ',
                                    ]),
                                Forms\Components\Select::make('rank')->required()->label('Hạng')
                                    ->options([
                                        'vàng' => 'Vàng',
                                        'bạc' => 'Bạc',
                                        'đồng' => 'Đồng',
                                    ]),
                                Forms\Components\DatePicker::make('date')->required()->label('Ngày sinh'),



                            ])->columns(1),
                        Forms\Components\Section::make()
                            ->schema([

                                Forms\Components\FileUpload::make('image'),

                            ])
                    ]),





            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Mã KH')->toggleable()->sortable(),
                Tables\Columns\ImageColumn::make('image')->toggleable()->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable()->label('Họ tên')->toggleable(),
                Tables\Columns\TextColumn::make('date')->label('Ngày sinh')->toggleable()->sortable(),
                Tables\Columns\TextColumn::make('phone')->label('Số điện thoại')->toggleable()->sortable(),
                Tables\Columns\TextColumn::make('gender')->label('Giới tính')->toggleable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->toggleable()->sortable(),
                Tables\Columns\TextColumn::make('rank')->toggleable()->sortable()
                    ->label('Hạng')
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
