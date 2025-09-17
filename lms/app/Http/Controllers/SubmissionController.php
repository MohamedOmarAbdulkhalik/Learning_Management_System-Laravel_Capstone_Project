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
