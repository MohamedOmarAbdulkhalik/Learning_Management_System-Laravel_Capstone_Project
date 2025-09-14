<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Assignment;
use App\Models\Lesson;
use App\Models\User;

class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;

    public function definition(): array
    {
        return [
            'lesson_id' => Lesson::factory(),
            'instructor_id' => User::factory()->instructor(),
            'title' => $this->faker->sentence(5),
            'description' => $this->faker->paragraph(),
            'due_date' => $this->faker->dateTimeBetween('+3 days', '+30 days'),
        ];
    }
}
