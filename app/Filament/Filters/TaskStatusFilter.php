<?php

namespace App\Filament\Filters;

use App\Enums\TaskStatus;
use Filament\Tables\Filters\SelectFilter;

class TaskStatusFilter
{
    public static function make(): SelectFilter
    {
        return SelectFilter::make('status')
            ->options([
                'Pending' => TaskStatus::PENDING->value,
                'In Progress' => TaskStatus::IN_PROGRESS->value,
                'Completed' => TaskStatus::COMPLETED->value,
                'Cancelled' => TaskStatus::CANCELLED->value,
                'On Hold' => TaskStatus::ON_HOLD->value,
            ]);
    }
}
