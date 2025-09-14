<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // افتراضي: "password"
            'remember_token' => Str::random(10),
            'role' => 'student', // القيمة الافتراضية
        ];
    }

    // حالات مساعدة
    public function instructor()
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'instructor',
        ]);
    }

    public function admin()
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'admin',
        ]);
    }
}
