<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Assignment;
use App\Models\Submission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin (اختياري)
        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Instructor أساسي
        $instructor = User::factory()->instructor()->create([
            'name' => 'Main Instructor',
            'email' => 'instructor@example.com',
            'password' => Hash::make('password123'),
        ]);

        // بعض الطلاب
        $students = User::factory(8)->create();

        // كورسات مرتبطة بالمدرس
        $courses = Course::factory(3)->for($instructor, 'instructor')->create();

        foreach ($courses as $course) {
            // سجل بعض الطلاب في الكورس (enrollments pivot)
            $course->students()->attach($students->random(5)->pluck('id')->toArray());

            // دروس لكل كورس
            $lessons = Lesson::factory(5)->for($course)->create();

            foreach ($lessons as $lesson) {
                // واجبتان لكل درس
                $assignments = Assignment::factory(2)->for($lesson)->for($instructor, 'instructor')->create();

                foreach ($assignments as $assignment) {
                    // لكل واجب، أنشئ حلول من 3 طلاب مختلفين
                    $selected = $students->random(3);
                    foreach ($selected as $student) {
                        Submission::factory()->for($assignment)->for($student, 'student')->create();
                    }
                }
            }
        }
    }
}