<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Submission;
use App\Models\Assignment;
use App\Models\User;

class SubmissionFactory extends Factory
{
    protected $model = Submission::class;

    public function definition(): array
    {
        return [
            'assignment_id' => Assignment::factory(),
            'student_id' => User::factory(), // UserFactory افتراضيًا يضع role = student
            'content' => $this->faker->paragraph(),
            'file_path' => null,
            'grade' => null,
            'feedback' => null,
            'status' => 'submitted',
        ];
    }
}
