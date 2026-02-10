<?php

namespace App\Filament\Filters;

use Filament\Tables\Filters\SelectFilter;

class UserFilter
{
    public static function make(): SelectFilter
    {
        return SelectFilter::make('user_id')
            ->relationship('user', 'name')
            ->preload()
            ->searchable()
            ->default(auth()->id());
    }
}
