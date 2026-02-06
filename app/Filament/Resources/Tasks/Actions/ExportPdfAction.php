<?php

namespace App\Filament\Resources\Tasks\Actions;

use App\Filament\Resources\Tasks\Pages\ListTasks;
use App\Jobs\ExportTasksPdf;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class ExportPdfAction
{
    public static function make(): Action
    {
        return Action::make('export_pdf')
            ->label('Export PDF')
            ->icon('heroicon-o-document-arrow-down')
            ->color('success')
            ->action(function (ListTasks $livewire): void {
                $query = $livewire->getFilteredTableQuery();
                $taskIds = $query->pluck('id')->toArray();

                if (count($taskIds) === 0) {
                    Notification::make()
                        ->warning()->title('No tasks found')->send();

                    return;
                }

                ExportTasksPdf::dispatch(auth()->user(), $taskIds);

                Notification::make()
                    ->title('Export started')
                    ->body('We will notify you when the file is ready.')
                    ->info()
                    ->send();
            });
    }
}
