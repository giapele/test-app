<?php

namespace App\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use App\Models\Reminder;
use App\Models\Associate;
use Filament\Forms;
use Filament\Forms\Components\{DateTimePicker, Select, TextInput, Textarea, Toggle, Grid, ColorPicker, Hidden, Checkbox, Repeater};
use Filament\Actions as FilamentActions;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class CalendarWidget extends FullCalendarWidget
{


    public Model|string|null $model = Event::class;
    public $selectedUsers = null;
    public function mount(): void
    {
        $this->selectedUsers = Session::get('calendar_selected_users', [auth()->id()]);
    }

    public function fetchEvents(array $fetchInfo): array
    {
        $eventsQuery = Event::whereBetween('start', [$fetchInfo['start'], $fetchInfo['end']]);

        return $eventsQuery->get()
            ->map(fn($event) => [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
            ])->toArray();
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required()->label(__('labels.title')),
            Repeater::make('reminders')
                ->label(__('labels.reminders'))
                ->relationship()
                ->schema([
                    TextInput::make('name')
                        ->label(__('labels.reminder_name'))
                        ->required(),

                ])
        ];
    }
}