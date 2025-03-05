<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceResource\Pages;
use App\Filament\Resources\DeviceResource\RelationManagers;
use App\Models\Device;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench';
    public static function getNavigationGroup(): string
    {
        return __('module_names.navigation_groups.administration');
    }
    public static function getModelLabel(): string
    {
        return __('module_names.devices.label');
    }
    public static function getPluralModelLabel(): string
    {
        return __('module_names.devices.plural_label');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')->label(__('fields.name'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('erp_code')->label(__('fields.erp_code'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Select::make('type_id')->label(__('fields.type'))
                            ->relationship('type', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')->label(__('fields.name'))
                                    ->required()
                                    ->unique()
                                    ->maxLength(255)
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('plant')->label(__('fields.plant'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('active')->label(__('fields.active'))
                            ->onColor('success')
                            ->offColor('danger')
                            ->columnSpan('full'),
                        Forms\Components\TextInput::make('history')->label(__('fields.history'))
                            ->maxLength(255),
                        Forms\Components\TextInput::make('note')->label(__('fields.note'))
                            ->maxLength(255),
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'view' => Pages\ViewDevice::route('/{record}'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
        ];
    }
}
