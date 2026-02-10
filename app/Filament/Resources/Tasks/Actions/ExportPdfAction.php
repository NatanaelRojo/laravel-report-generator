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
                $taskIds = self::validateTaskFilters($livewire);

                if (! $taskIds) {
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

    protected static function validateTaskFilters(ListTasks $livewire): ?array
    {
        $filterData = $livewire->tableFilters;

        $projectId = $filterData['project_id']['value'] ?? null;
        $userId = $filterData['user_id']['value'] ?? null;

        if (empty($userId)) {
            Notification::make()
                ->title('Action Required')
                ->body('Please select a Developer in the filters before exporting.')
                ->warning()
                ->send();

            return null;
        }

        if (empty($projectId)) {
            Notification::make()
                ->title('Action Required')
                ->body('Please select a Project in the filters before exporting.')
                ->warning()
                ->send();

            return null;
        }

        $query = $livewire->getFilteredTableQuery();
        $taskIds = $query->pluck('id')->toArray();

        if (count($taskIds) === 0) {
            Notification::make()
                ->warning()->title('No tasks found')->send();

            return null;
        }

        return $taskIds;
    }
}
