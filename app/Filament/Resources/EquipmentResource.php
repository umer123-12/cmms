<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentResource\Pages;
use App\Filament\Resources\EquipmentResource\RelationManagers;
use App\Models\Equipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench';
    protected static ?int $navigationSort = 8;
    public static function getNavigationGroup(): string
    {
        return __('module_names.navigation_groups.maintenance');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('type')->required(),
                Forms\Components\TextInput::make('manufacturer'),
                Forms\Components\TextInput::make('serial_number')->required()->unique(),
                Forms\Components\DatePicker::make('purchase_date'),
                Forms\Components\TextInput::make('value')->numeric(),
                Forms\Components\TextInput::make('location'),
                Forms\Components\Select::make('status')->options([
                                'Operational' => 'Operational',
                                'Broken' => 'Broken',
                                'Retired' => 'Retired',
                            ]),
                Forms\Components\DatePicker::make('warranty_expiry'),

            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('type')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('manufacturer')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('serial_number')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('purchase_date')
                ->date()
                ->sortable(),

            Tables\Columns\TextColumn::make('value')
                ->money('PKR') // Change to your currency
                ->sortable(),

            Tables\Columns\TextColumn::make('location')
                ->sortable()
                ->searchable(),

            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'success' => 'Operational',
                    'danger' => 'Broken',
                    'gray' => 'Retired',
                ])
                ->sortable(),

            Tables\Columns\TextColumn::make('warranty_expiry')
                ->date()
                ->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'Operational' => 'Operational',
                    'Broken' => 'Broken',
                    'Retired' => 'Retired',
                ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ])
        ->defaultSort('name');
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
            'index' => Pages\ListEquipment::route('/'),
            'create' => Pages\CreateEquipment::route('/create'),
            'edit' => Pages\EditEquipment::route('/{record}/edit'),
        ];
    }
}
