<?php

namespace App\Models;

use Database\Factories\TaskFactory;
use App\Enums\TaskStatus as EnumsTaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => EnumsTaskStatus::class,
        ];
    }
}
