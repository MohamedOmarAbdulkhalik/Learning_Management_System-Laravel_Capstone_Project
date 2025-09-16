<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Assignment;
use App\Models\Submission;
use App\Policies\CoursePolicy;
use App\Policies\LessonPolicy;
use App\Policies\AssignmentPolicy;
use App\Policies\SubmissionPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Course::class => CoursePolicy::class,
        Lesson::class => LessonPolicy::class,
        Assignment::class => AssignmentPolicy::class,
        Submission::class => SubmissionPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('isInstructor', function ($user) {
            return $user->role === 'instructor';
        });

        Gate::define('isStudent', function ($user) {
            return $user->role === 'student';
        });
    }
}