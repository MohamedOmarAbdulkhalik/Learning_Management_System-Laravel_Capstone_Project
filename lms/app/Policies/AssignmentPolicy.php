<?php

namespace App\Policies;

use App\Models\Assignment;
use App\Models\User;
use App\Models\Lesson;

class AssignmentPolicy
{
    /**
     * Determine whether the user can create assignments.
     */
public function create(User $user, Assignment $assignment): bool
{
    return $user->role === 'admin' || 
           ($user->role === 'instructor' && $assignment->lesson->course->instructor_id == $user->id);
}


    public function update(User $user, Assignment $assignment): bool
    {
        return $user->role === 'admin' || 
            ($user->role === 'instructor' && $assignment->lesson->course->instructor_id == $user->id);
    }

    public function delete(User $user, Assignment $assignment): bool
    {
        return $this->update($user, $assignment);
    }

      public function submit(User $user, Assignment $assignment): bool
    {
        // الطالب يجب أن يكون مسجلاً في الكورس المرتبط
        if ($user->role !== 'student') return false;
        return $user->courses()->where('courses.id', $assignment->lesson->course_id)->exists();
    }
}
