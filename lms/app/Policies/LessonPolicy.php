<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Course;

class LessonPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // الجميع يمكنه رؤية قائمة الدروس
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Lesson $lesson): bool
    {
        return true; // الجميع يمكنه رؤية الدرس
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Course $course): bool
    {
        return $user->role === 'admin' || 
               ($user->role === 'instructor' && $course->instructor_id == $user->id);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Lesson $lesson): bool
    {
        return $user->role === 'admin' || 
               ($user->role === 'instructor' && $lesson->course->instructor_id == $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Lesson $lesson): bool
    {
        return $this->update($user, $lesson);
    }
}