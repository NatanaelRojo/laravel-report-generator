<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
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
        $daysToDueDate = $this->faker->numberBetween(1, 30);
        $startDate = now()->addDays(rand(1, 30));

        return [
            'project_id' => Project::factory(),
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(TaskStatus::valuesToArray()),
                        'verification_links' => collect(range(1, rand(1, 3)))->map(fn() => [
                'url' => $this->faker->url(),
            ])->toArray(),
            'start_date' => $startDate,
            'end_date' => $startDate->copy()->addDays(rand(1, $daysToDueDate)),
            'due_date' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['start_date'], $attributes['end_date']);
            },
        ];
    }
}
