<?php

namespace App\Filament\Resources\Tasks\Tables;

use App\Filament\Filters\DateRangeFilter;
use App\Filament\Filters\ProjectFilter;
use App\Filament\Filters\TaskStatusFilter;
use App\Filament\Filters\UserFilter;
use App\Filament\Resources\Tasks\Actions\ExportPdfAction;
use App\Jobs\ExportTasksPdf;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;

class TasksTable
{
    public static function getColumns(): array
    {
        return [
            TextColumn::make('project.name')
                ->searchable(),
            TextColumn::make('user.name')
                ->searchable(),
            TextColumn::make('title')
                ->searchable(),
            TextColumn::make('status')
                ->badge()
                ->searchable(),
            TextColumn::make('start_date')
                ->date()
                ->sortable(),
            TextColumn::make('end_date')
                ->date()
                ->sortable(),
            TextColumn::make('due_date')
                ->date()
                ->sortable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public static function getFilters(): array
    {
        return [
            DateRangeFilter::make('start_date'),
            DateRangeFilter::make('end_date'),
            DateRangeFilter::make('due_date'),
            UserFilter::make(),
            TaskStatusFilter::make(),
            ProjectFilter::make(),
        ];
    }

        public static function getHeaderActions(): array
    {
        return [
            ExportPdfAction::make(),
        ];
    }

    public static function getActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public static function getBulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ];
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns(static::getColumns())
            ->filters(static::getFilters(), layout: FiltersLayout::AboveContentCollapsible)
            ->headerActions(static::getHeaderActions())
            ->recordActions(static::getActions())
            ->toolbarActions(static::getBulkActions());
    }
}
