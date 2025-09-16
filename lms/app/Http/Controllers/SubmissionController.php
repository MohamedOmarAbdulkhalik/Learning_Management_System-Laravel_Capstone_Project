<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use App\Http\Requests\SubmissionRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // طالب يرفع حل
    public function store(SubmissionRequest $request, Assignment $assignment)
    {
        $this->authorize('create', [\App\Models\Submission::class, $assignment]); // SubmissionPolicy::create(User, Assignment)

        $data = $request->validated();
        $data['assignment_id'] = $assignment->id;
        $data['student_id'] = auth()->id();

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('submissions', 'public');
            $data['file_path'] = $path;
        }

        // منع تكرار: لو الطالب سبق وقدم حلًا واحدًا لكل واجب (أو قم بالسماح بعدد)
        $existing = Submission::where('assignment_id', $assignment->id)
            ->where('student_id', auth()->id())
            ->first();

        if ($existing) {
            // نحدّث الـ submission القديم
            $existing->update(array_merge($data, ['status' => 'submitted', 'grade' => null, 'feedback' => null]));
            $submission = $existing;
        } else {
            $submission = Submission::create($data);
        }

        // (اختياري) إرسال إشعار للمدرّس — يمكن إضافته لاحقًا.
        return redirect()->back()->with('success','Submission uploaded successfully.');
    }

    // المدرّس يقوّم submission ويضع grade + feedback
    public function grade(Request $request, Submission $submission)
    {
        // authorization
        $this->authorize('grade', $submission);

        $data = $request->validate([
            'grade' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $submission->update([
            'grade' => $data['grade'],
            'feedback' => $data['feedback'] ?? null,
            'status' => 'graded',
        ]);

        // (اختياري) إشعار للطالب

        return redirect()->back()->with('success','Submission graded successfully.');
    }

    // عرض submission (student + instructor)
    public function show(Submission $submission)
    {
        $this->authorize('view', $submission);
        return view('submissions.show', compact('submission'));
    }
}
