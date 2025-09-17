<?php

namespace App\Policies;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Models\Assignment;

class SubmissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }


    public function submit(User $user, Assignment $assignment): bool
    {
        // الطالب يجب أن يكون مسجلاً في الكورس المرتبط
        if ($user->role !== 'student') return false;
        return $user->courses()->where('courses.id', $assignment->lesson->course_id)->exists();
    }

    public function grade(User $user, Submission $submission): bool
    {
        // admin أو instructor صاحب الكورس
        $courseInstructorId = $submission->assignment->lesson->course->instructor_id;
        return $user->role === 'admin' || ($user->role === 'instructor' && $user->id == $courseInstructorId);
    }

    public function view(User $user, Submission $submission): bool
    {
        // الطالب صاحب الحل أو المدرس/ادمن
        if ($user->role === 'admin') return true;
        if ($user->role === 'instructor' && $submission->assignment->lesson->course->instructor_id == $user->id) return true;
        return $user->id === $submission->student_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Submission $submission): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Submission $submission): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Submission $submission): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Submission $submission): bool
    {
        return false;
    }
}
