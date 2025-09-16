<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    protected $policies = [
        \App\Models\Course::class => \App\Policies\CoursePolicy::class,
        \App\Models\Lesson::class => \App\Policies\LessonPolicy::class,
        \App\Models\Course::class => \App\Policies\CoursePolicy::class,
        \App\Models\Assignment::class => \App\Policies\AssignmentPolicy::class,
        \App\Models\Submission::class => \App\Policies\SubmissionPolicy::class,

    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->register();

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
