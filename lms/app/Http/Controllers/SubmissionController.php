<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use App\Http\Requests\SubmissionRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Submission::with(['assignment.lesson.course', 'student']);

        // الفلترة حسب الدور
        if ($user->role === 'admin') {
            // يشوف كل شي
        } elseif ($user->role === 'instructor') {
            // واجبات مرتبطة بكورسات الاستاذ
            $query->whereHas('assignment.lesson.course', function($q) use ($user) {
                $q->where('instructor_id', $user->id);
            });
        } else {
            // طالب → واجباته فقط
            $query->where('student_id', $user->id);
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة حسب الكورس
        if ($request->filled('course_id')) {
            $query->whereHas('assignment.lesson.course', function($q) use ($request) {
                $q->where('id', $request->course_id);
            });
        }

        // فلترة حسب الدرس
        if ($request->filled('lesson_id')) {
            $query->whereHas('assignment.lesson', function($q) use ($request) {
                $q->where('id', $request->lesson_id);
            });
        }

        $submissions = $query->paginate(15);
        $courses = Course::all(); // للفلتر
        $lessons = Lesson::all(); // للفلتر

        return view('submissions.index', compact('submissions','courses','lessons'));
    }

    public function create(Course $course, Lesson $lesson, Assignment $assignment)
    {
        $this->authorize('submit', $assignment);
        return view('submissions.create', compact('course','lesson','assignment'));
    }

public function store(Request $request, Course $course, Lesson $lesson, Assignment $assignment)
{
    $this->authorize('submit', $assignment);

    $data = $request->validate([
        'content' => 'nullable|string',
        'file' => 'nullable|file|max:2048',
    ]);

    $path = null;
    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('submissions');
    }

    Submission::create([
        'assignment_id' => $assignment->id,
        'student_id' => auth()->id(),
        'content' => $data['content'] ?? null,
        'file_path' => $path,
    ]);

    return redirect()->route('courses.lessons.show', [$course, $lesson])
                    ->with('success','Submission uploaded successfully.');
}
}
