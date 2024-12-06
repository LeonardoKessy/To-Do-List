<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => User::inRandomOrder()->value('id') ?? User::factory(),
            "tittle" => $this->faker->sentence(3),
            "detail" => $this->faker->sentence(12),
            "color" => $this->faker->randomElement(['red', 'blue', 'yellow', 'purple'])
        ];
    }
}
