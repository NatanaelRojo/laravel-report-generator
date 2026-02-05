<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $existingUsers = User::all();
        $existingProjects = Project::all();

        Task::factory()
            ->count(200)
            ->recycle($existingProjects)
            ->recycle($existingUsers)
            ->create();
    }
}
