<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Enums\TaskStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
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
                ->searchable(),
            TextInput::make('title')
                ->required(),
            Textarea::make('description')
                ->columnSpanFull(),
            Select::make('status')
                ->options(TaskStatus::class)
                ->default(TaskStatus::PENDING->value)
                ->required(),
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
