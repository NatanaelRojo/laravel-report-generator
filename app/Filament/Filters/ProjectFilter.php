<?php

namespace App\Filament\Filters;

use Filament\Tables\Filters\SelectFilter;

class ProjectFilter
{
    public static function make(): SelectFilter
    {
        return SelectFilter::make('project_id')
            ->relationship('project', 'name')
            ->preload()
            ->searchable();
    }
}
