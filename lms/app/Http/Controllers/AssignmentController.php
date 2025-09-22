<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Assignment;
use App\Http\Requests\AssignmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 

class AssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Course $course, Lesson $lesson)
    {
        if ($lesson->course_id !== $course->id) abort(404);

        $assignments = $lesson->assignments()->orderBy('created_at', 'desc')->paginate(10);

        // Log العملية
        Log::channel('assignment')->info('Assignments listed', [
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'lesson_id' => $lesson->id,
            'count' => $assignments->total(),
            'url' => request()->fullUrl(),
        ]);

        return view('assignments.index', compact('course', 'lesson', 'assignments'));
    }

    public function create(Course $course, Lesson $lesson)
    {
        if ($lesson->course_id !== $course->id) abort(404);

        Log::channel('assignment')->info('Create assignment form opened', [
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'lesson_id' => $lesson->id,
        ]);

        return view('assignments.create', compact('course', 'lesson'));
    }

    public function store(AssignmentRequest $request, Course $course, Lesson $lesson)
    {
        if ($lesson->course_id !== $course->id) abort(404);

        $data = $request->validated();
        $data['lesson_id'] = $lesson->id;
        $data['instructor_id'] = auth()->id();

        $assignment = Assignment::create($data);

        Log::channel('assignment')->info('Assignment created', [
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'lesson_id' => $lesson->id,
            'assignment_id' => $assignment->id,
            'title' => $assignment->title,
        ]);

        return redirect()->route('courses.lessons.assignments.index', [$course, $lesson])
            ->with('success', 'Assignment created successfully.');
    }

    public function show(Course $course, Lesson $lesson, Assignment $assignment)
    {
        if ($assignment->lesson_id !== $lesson->id || $lesson->course_id !== $course->id) abort(404);

        $assignment->load('submissions.student');

        Log::channel('assignment')->info('Assignment viewed', [
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'lesson_id' => $lesson->id,
            'assignment_id' => $assignment->id,
        ]);

        return view('assignments.show', compact('course', 'lesson', 'assignment'));
    }

    public function edit(Course $course, Lesson $lesson, Assignment $assignment)
    {
        if ($assignment->lesson_id !== $lesson->id || $lesson->course_id !== $course->id) abort(404);

        Log::channel('assignment')->info('Edit form opened', [
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'lesson_id' => $lesson->id,
            'assignment_id' => $assignment->id,
        ]);

        return view('assignments.edit', compact('course', 'lesson', 'assignment'));
    }

    public function update(AssignmentRequest $request, Course $course, Lesson $lesson, Assignment $assignment)
    {
        if ($assignment->lesson_id !== $lesson->id || $lesson->course_id !== $course->id) abort(404);

        $assignment->update($request->validated());

        Log::channel('assignment')->info('Assignment updated', [
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'lesson_id' => $lesson->id,
            'assignment_id' => $assignment->id,
        ]);

        return redirect()->route('courses.lessons.assignments.index', [$course, $lesson])
            ->with('success', 'Assignment updated successfully.');
    }

    public function destroy(Course $course, Lesson $lesson, Assignment $assignment)
    {
        if ($assignment->lesson_id !== $lesson->id || $lesson->course_id !== $course->id) abort(404);

        $assignment->delete();

        Log::channel('assignment')->warning('Assignment deleted', [
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'lesson_id' => $lesson->id,
            'assignment_id' => $assignment->id,
        ]);

        return redirect()->route('courses.lessons.assignments.index', [$course, $lesson])
            ->with('success', 'Assignment deleted.');
    }
}
