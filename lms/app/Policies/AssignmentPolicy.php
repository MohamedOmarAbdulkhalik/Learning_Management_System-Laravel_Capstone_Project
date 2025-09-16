<?php

namespace App\Policies;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Models\Lesson;

class AssignmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Assignment $assignment): bool
    {
        return false;
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Assignment $assignment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Assignment $assignment): bool
    {
        return false;
    }

    public function create(User $user, Lesson $lesson): bool
    {
        // admin أو instructor صاحب الكورس
        return $user->role === 'admin' || ($user->role === 'instructor' && $lesson->course->instructor_id == $user->id);
    }

    public function update(User $user, Assignment $assignment): bool
    {
        return $user->role === 'admin' || ($user->role === 'instructor' && $assignment->lesson->course->instructor_id == $user->id);
    }

    public function delete(User $user, Assignment $assignment): bool
    {
        return $this->update($user, $assignment);
    }

}
