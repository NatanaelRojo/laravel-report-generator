<?php

namespace App\Filament\Filters;

use App\Enums\TaskStatus;
use Filament\Tables\Filters\SelectFilter;

class TaskStatusFilter
{
    public static function make(): SelectFilter
    {
        return SelectFilter::make('status')
            ->options(TaskStatus::valuesToArray());
    }
}
