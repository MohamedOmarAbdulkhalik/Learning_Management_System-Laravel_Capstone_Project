<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Http\Requests\LessonRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // /courses/{course}/lessons
    public function index(Course $course)
    {
        $lessons = $course->lessons()
            ->withCount('assignments')
            ->orderBy('created_at','desc')
            ->paginate(10);

        return view('lessons.index', compact('course','lessons'));
    }

    // GET create
    public function create(Course $course)
    {
        $this->authorize('create', [Lesson::class, $course]);   // Policy
        return view('lessons.create', compact('course'));
    }

    // POST store
    public function store(LessonRequest $request, Course $course)
    {
        $this->authorize('create', [Lesson::class, $course]);

        $data = $request->validated();
        $data['course_id'] = $course->id;

        if ($request->hasFile('resource')) {
            $path = $request->file('resource')->store('lessons/resources', 'public');
            $data['resource_path'] = $path;
        }

        Lesson::create($data);

        return redirect()
            ->route('courses.lessons.index', $course)
            ->with('success', 'تمت إضافة الدرس بنجاح');
    }

    // GET show
    public function show(Course $course, Lesson $lesson)
    {
        if ($lesson->course_id !== $course->id) abort(404);

        $lesson->load('assignments');
        return view('lessons.show', compact('course','lesson'));
    }

    // GET edit
    public function edit(Course $course, Lesson $lesson)
    {
        if ($lesson->course_id !== $course->id) abort(404);

        $this->authorize('update', $lesson);
        return view('lessons.edit', compact('course','lesson'));
    }

    // PUT update
    public function update(LessonRequest $request, Course $course, Lesson $lesson)
    {
        if ($lesson->course_id !== $course->id) abort(404);

        $this->authorize('update', $lesson);

        $data = $request->validated();

        if ($request->hasFile('resource')) {
            if ($lesson->resource_path && Storage::disk('public')->exists($lesson->resource_path)) {
                Storage::disk('public')->delete($lesson->resource_path);
            }
            $path = $request->file('resource')->store('lessons/resources', 'public');
            $data['resource_path'] = $path;
        }

        $lesson->update($data);

        return redirect()
            ->route('courses.lessons.index', $course)
            ->with('success', 'تم تحديث الدرس بنجاح');
    }

    // DELETE destroy
    public function destroy(Course $course, Lesson $lesson)
    {
        if ($lesson->course_id !== $course->id) abort(404);

        $this->authorize('delete', $lesson);

        if ($lesson->resource_path && Storage::disk('public')->exists($lesson->resource_path)) {
            Storage::disk('public')->delete($lesson->resource_path);
        }

        $lesson->delete();

        return redirect()
            ->route('courses.lessons.index', $course)
            ->with('success', 'تم حذف الدرس بنجاح');
    }
}
