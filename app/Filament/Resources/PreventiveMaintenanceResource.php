<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\PreventiveMaintenance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PreventiveMaintenanceResource\Pages;
use App\Filament\Resources\PreventiveMaintenanceResource\RelationManagers;

class PreventiveMaintenanceResource extends Resource
{
    protected static ?string $model = PreventiveMaintenance::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';
    protected static ?int $navigationSort = 10;
        public static function getNavigationGroup(): string
    {
        return __('module_names.navigation_groups.maintenance');
    }
// public   Model | string | null $model = PreventiveMaintenance::class;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                  Forms\Components\Select::make('equipment_id')
                ->relationship('equipment', 'name') // adjust 'name' to your equipment display column
                ->required(),

            Forms\Components\TextInput::make('title')
                ->required(),

            Forms\Components\Select::make('type')
                ->options([
                    'time-based' => 'Time Based',
                    'usage-based' => 'Usage Based',
                ])
                ->reactive()
                ->required(),

            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\TextInput::make('interval_days')
                        ->numeric()
                        ->label('Interval (Days)')
                        ->visible(fn ($get) => $get('type') === 'time-based'),

                    Forms\Components\TextInput::make('interval_usage')
                        ->numeric()
                        ->label('Interval (Usage)')
                        ->visible(fn ($get) => $get('type') === 'usage-based'),
                ]),

            Forms\Components\DatePicker::make('last_maintenance_date'),
            Forms\Components\DatePicker::make('next_due_date'),

            Forms\Components\DateTimePicker::make('starts_at'),
            Forms\Components\DateTimePicker::make('ends_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('equipment.name')
                ->label('Equipment')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('title')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('type')
                ->badge()
                ->colors([
                    'primary' => 'time-based',
                    'warning' => 'usage-based',
                ])
                ->sortable(),

            Tables\Columns\TextColumn::make('interval_days')
                ->label('Interval (Days)')
                ->sortable(),
                // ->visible(fn ($record) => $record['type'] === 'time-based'),

            Tables\Columns\TextColumn::make('interval_usage')
                ->label('Interval (Usage)')
                ->sortable(),
                // ->visible(fn ($record) => $record['type'] === 'usage-based'),

            Tables\Columns\TextColumn::make('last_maintenance_date')
                ->date()
                ->sortable(),

            Tables\Columns\TextColumn::make('next_due_date')
                ->date()
                ->sortable(),

            Tables\Columns\TextColumn::make('starts_at')
                ->dateTime()
                ->label('Starts At'),

            Tables\Columns\TextColumn::make('ends_at')
                ->dateTime()
                ->label('Ends At'),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('type')
                ->options([
                    'time-based' => 'Time Based',
                    'usage-based' => 'Usage Based',
                ]),

            Tables\Filters\TernaryFilter::make('last_maintenance_date')
                ->label('Has Last Maintenance Date')
                ->nullable(),

            Tables\Filters\Filter::make('next_due_date')
                ->label('Next Due Date in Next 7 Days')
                ->query(fn (Builder $query) => $query->whereBetween('next_due_date', [now(), now()->addDays(7)])),
        ])
        ->actions([
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
            'index' => Pages\ListPreventiveMaintenances::route('/'),
            'create' => Pages\CreatePreventiveMaintenance::route('/create'),
            'edit' => Pages\EditPreventiveMaintenance::route('/{record}/edit'),
        ];
    }
}
