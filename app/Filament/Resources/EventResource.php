<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Components\{DateTimePicker, Select, TextInput, Textarea, Toggle, Grid, ColorPicker, Hidden, Checkbox, Repeater};
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Resources\Resource;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    
    public static function getNavigationLabel(): string
    {
        return __('labels.events');
    }
    public static function getNavigationGroup(): string
    {
        return __('labels.chronos_crm');
    } 

    public static function getModelLabel(): string
    {
        return __('labels.event');
    }

    public static function getPluralModelLabel(): string
    {
        return __('labels.events');
    }
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
            TextInput::make('title')
                ->required()
                ->label(__('labels.title')),
            Repeater::make('reminders')
                ->label(__('labels.reminders'))
                ->relationship('reminders')
                ->schema([
            TextInput::make('name')
                ->label(__('labels.reminder_name'))
                ->required(),
            
            
                ]),
            DateTimePicker::make('start')->required()->label(__('labels.event_start'))->withoutSeconds()->native(false),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
            TextColumn::make('title')
                ->label(__('labels.title'))
                ->searchable()
                ->sortable(),
            TextColumn::make('start')
                ->label(__('labels.event_start'))
                ->dateTime()
                ->sortable(),
            ])
            ->filters([
                // Define any filters you may want here
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define relationships here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}