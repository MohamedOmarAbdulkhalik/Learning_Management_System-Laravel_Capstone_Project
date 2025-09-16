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
public function create(User $user, Lesson $lesson): bool
{
    return $user->role === 'admin' || 
           ($user->role === 'instructor' && $lesson->course->instructor_id == $user->id);
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
}
