<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $existingTasks = Task::all();
        $existingUsers = User::all();

        Note::factory()
            ->count(300)
            ->recycle($existingTasks)
            ->recycle($existingUsers)
            ->create();
    }
}
