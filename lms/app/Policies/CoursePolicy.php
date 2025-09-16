<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{
    public function viewAny(User $user)
    {
        return true; // الجميع يمكنه رؤية قائمة الكورسات
    }

    public function view(User $user, Course $course)
    {
        return true; // أو تضييقها إن أردت
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'instructor']);
    }

    public function update(User $user, Course $course)
    {
        return $user->role === 'admin' || ($user->role === 'instructor' && $course->instructor_id == $user->id);
    }

    public function delete(User $user, Course $course)
    {
        return $this->update($user, $course);
    }

    /**
     * Determine whether the user can enroll in the course.
     */
    public function enroll(User $user, Course $course): bool
    {
        return $user->role === 'student';
    }

    /**
     * Determine whether the user can unenroll from the course.
     */
    public function unenroll(User $user, Course $course): bool
    {
        return $user->role === 'student';
    }

    /**
     * Determine whether the user can manage lessons inside the course.
     */
    public function manageLessons(User $user, Course $course): bool
    {
        return $this->update($user, $course); 
        // المدرّب مالك الكورس أو الأدمن
    }
}
