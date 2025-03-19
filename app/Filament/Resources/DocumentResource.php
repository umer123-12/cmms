<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Filament\Resources\DocumentResource\RelationManagers;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    public static function getNavigationGroup(): string
    {
        return __('module_names.navigation_groups.administration');
    }
    public static function getModelLabel(): string
    {
        return __('module_names.documents.label');
    }
    public static function getPluralModelLabel(): string
    {
        return __('module_names.documents.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('name')->label(__('fields.name'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\Select::make('device_id')->label(__('module_names.devices.label'))
                    ->relationship('device', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\FileUpload::make('attachment')->label(__('fields.attachment'))
                    ->required()
                    ->preserveFilenames()
                    ->openable()
                    ->downloadable()
                    ->maxSize(20000),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->label(__('fields.name'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('device.name')->label(__('module_names.devices.label'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('fields.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->searchable()->sortable(),

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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'view' => Pages\ViewDocument::route('/{record}'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
