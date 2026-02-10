<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action as ActionsAction;
use Filament\Notifications\Notification;
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
        $records = Task::whereIn('id', $this->taskIds)
            ->with(['project', 'user'])
            ->get();

        $pdf = Pdf::loadView('pdf.tasks-report', [
            'records' => $records,
            'user' => $this->user,
        ]);

        // 3. Save it to a temporary public disk
        $fileName = 'reports/tasks-'.now()->timestamp.'.pdf';
        Storage::disk('public')->put($fileName, $pdf->output());

        Notification::make()
            ->title('Report Ready')
            ->body('Your tasks export has been generated successfully.')
            ->success()
            ->actions([
                ActionsAction::make('download')
                    ->button()
                    ->url(Storage::url($fileName), shouldOpenInNewTab: true),
            ])
            ->sendToDatabase($this->user); // <--- Key magic here
    }
}
