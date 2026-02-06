<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Task;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action as ActionsAction;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ExportTasksPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public array $taskIds
    ) {}

    public function handle(): void
    {
        // 1. Fetch the data using the IDs passed from the UI
        $records = Task::whereIn('id', $this->taskIds)
            ->with(['project', 'user'])
            ->get();

        // 2. Generate the PDF
        $pdf = Pdf::loadView('pdf.tasks-report', ['records' => $records]);
        
        // 3. Save it to a temporary public disk
        $fileName = 'reports/tasks-' . now()->timestamp . '.pdf';
        Storage::disk('public')->put($fileName, $pdf->output());

        // 4. Send the "Ready" Notification with a Download Button
        Notification::make()
            ->title('Report Ready')
            ->body('Your tasks export has been generated successfully.')
            ->success()
            ->actions([
                ActionsAction::make('download')
                    ->button()
                    ->url(Storage::url($fileName), shouldOpenInNewTab: true)
            ])
            ->sendToDatabase($this->user); // <--- Key magic here
    }
}