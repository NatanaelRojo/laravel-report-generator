<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function getFields(): array
    {
        return [
            Select::make('user_id')
                ->required()
                ->relationship(name: 'users', titleAttribute: 'name')
                ->preload()
                ->searchable(),
            TextInput::make('name')
                ->required(),
            Textarea::make('description')
                ->columnSpanFull(),
        ];
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(static::getFields());
    }
}
