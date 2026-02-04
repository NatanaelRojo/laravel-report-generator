<?php

namespace Database\Factories;

use App\Models\Task;
use App\Enums\TaskStatus;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'name' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(TaskStatus::valuesToArray()),
            'start_date' => $this->faker->optional()->date(),
            'end_date' => $this->faker->optional()->date(),
            'due_date' => $this->faker->optional()->date(),
        ];
    }
}
