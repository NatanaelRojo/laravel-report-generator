<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Enums\TaskStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function getFields(): array
    {
        return [
            Select::make('project_id')
                ->relationship('project', 'name')
                ->required(),
            Select::make('user_id')
                ->relationship('user', 'name')
                ->required()
                ->preload()
                ->searchable()
                ->default(auth()->id()),
            TextInput::make('title')
                ->required(),
            Textarea::make('description')
                ->columnSpanFull(),
            Select::make('status')
                ->options(TaskStatus::getArrayForFilamentSelector())
                ->default(TaskStatus::PENDING->value)
                ->required(),
            Repeater::make('verification_links')
                ->schema([
                    TextInput::make('url')
                        ->prefixIcon('heroicon-m-link')
                        ->label('Verification Link')
                        ->url()
                        ->required(),
                ])
                ->label('Verification Links')
                ->columns(2)
                ->columnSpanFull()
                ->createItemButtonLabel('Add Verification Link'),
            DatePicker::make('start_date'),
            DatePicker::make('end_date'),
            DatePicker::make('due_date'),
        ];
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(static::getFields());
    }
}
