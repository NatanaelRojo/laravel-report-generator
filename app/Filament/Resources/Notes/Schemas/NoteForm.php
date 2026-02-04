<?php

namespace App\Filament\Resources\Notes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class NoteForm
{
    public static function getFields(): array
    {
        return [
            Select::make('user_id')
                ->relationship(name: 'user', titleAttribute: 'name')
                ->required()
                ->preload()
                ->searchable(),
            Select::make('task_id')
                ->relationship('task', 'title')
                ->required(),
            Textarea::make('content')
                ->required()
                ->columnSpanFull(),
        ];
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(static::getFields());
    }
}
