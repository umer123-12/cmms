<?php

namespace App\Filament\Resources\PreventiveMaintenanceResource\Widgets;

use App\Models\PreventiveMaintenance;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Form;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Actions;
use Saade\FilamentFullCalendar\Actions\ViewAction;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Filament\Resources\PreventiveMaintenanceResource;

class CalendarWidget extends FullCalendarWidget
{
   public Model | string | null $model = PreventiveMaintenance::class;

    protected function getEvents(array $fetchInfo): array
    {
        return PreventiveMaintenance::query()
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (PreventiveMaintenance $event) => EventData::make()
                    ->id($event->id)
                    ->title($event->title ?? 'Maintenance Task') // fallback if title is null
                    ->start($event->starts_at)
                    ->end($event->ends_at)
                    ->url(
                        url: PreventiveMaintenanceResource::getUrl(name: 'view', parameters: ['record' => $event]),
                        shouldOpenUrlInNewTab: true
                    )
            )
            ->toArray();
    }

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function viewAction(): ViewAction
    {
        return ViewAction::make();
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('title')->required(),

            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\DateTimePicker::make('starts_at')->required(),
                    Forms\Components\DateTimePicker::make('ends_at')->required(),
                ]),
        ];
    }
}
