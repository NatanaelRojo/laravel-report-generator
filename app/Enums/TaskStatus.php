<?php

namespace App\Enums;

use App\Traits\HasEnumMethods;

enum TaskStatus: string
{
    use HasEnumMethods;

    case PENDING = 'Pending';
    case IN_PROGRESS = 'In Progress';
    case COMPLETED = 'Completed';
    case ON_HOLD = 'On Hold';
    case CANCELLED = 'Cancelled';
}
