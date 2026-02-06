<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasks Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        h1 { margin: 0; color: #1a202c; font-size: 24px; }
        .meta { font-size: 10px; color: #666; margin-top: 5px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f3f4f6; font-weight: bold; text-align: left; padding: 8px; border-bottom: 1px solid #ddd; }
        td { padding: 8px; border-bottom: 1px solid #eee; }
        
        .badge { padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: bold; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Project Tasks Report</h1>
        <div class="meta">Generated: {{ now()->format('F j, Y, g:i a') }} | Total Records: {{ $records->count() }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Project</th>
                <th>Task</th>
                <th>Developer</th>
                <th>Status</th>
                <th>Due Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $task)
            <tr>
                <td>{{ $task->project->name ?? 'N/A' }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->user->name ?? 'Unassigned' }}</td>
                <td>
                    <span class="badge" style="background-color: {{ $task->status->color ?? 'gray' }};">
                        {{ $task->status->name }}
                    </span>
                </td>
                <td>{{ $task->due_date?->format('Y-m-d') ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>