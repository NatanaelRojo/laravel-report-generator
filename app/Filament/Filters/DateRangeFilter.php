<?php

namespace App\Filament\Filters;

use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Fieldset;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class DateRangeFilter
{
    public static function make(string $column, ?string $label = null): Filter
    {
        $label ??= str($column)->headline();

        return Filter::make($column)
            ->form([
                Fieldset::make($label)
                    ->schema([
                        DatePicker::make('from')
                            ->label('From')
                            ->placeholder('Start Date'),
                        DatePicker::make('to')
                            ->label('To')
                            ->placeholder('End Date'),
                    ])
                    ->columns(1),
            ])
            ->query(function (Builder $query, array $data) use ($column) {
                $query
                    ->when(
                        $data['from'],
                        fn (Builder $query, $date): Builder => $query->whereDate($column, '>=', $date)
                    )
                    ->when(
                        $data['to'],
                        fn (Builder $query, $date): Builder => $query->whereDate($column, '<=', $date)
                    );
            })
            ->indicateUsing(
                function (array $data) use ($label): array {
                    return self::getIndicators($data, $label);
                }
            );
    }

    private static function getIndicators(array $data, string $label): array
    {
        $indicators = [];

        if ($data['from'] ?? null) {
            $indicators[] = "{$label} from ".Carbon::parse($data['from'])->toFormattedDateString();
        }
        if ($data['to'] ?? null) {
            $indicators[] = "{$label} to ".Carbon::parse($data['to'])->toFormattedDateString();
        }

        return $indicators;
    }
}
