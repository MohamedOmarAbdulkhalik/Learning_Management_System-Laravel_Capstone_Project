<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Assignment;
use App\Http\Requests\AssignmentRequest;
use Illuminate\Http\Request;
use App\Policies\AssignmentPolicy;


class AssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // /courses/{course}/lessons/{lesson}/assignments
    public function index(Course $course, Lesson $lesson)
    {
        if ($lesson->course_id !== $course->id) abort(404);

        $assignments = $lesson->assignments()->orderBy('created_at','desc')->paginate(10);
        return view('assignments.index', compact('course','lesson','assignments'));
    }

public function create(Course $course, Lesson $lesson)
{
    if ($lesson->course_id !== $course->id) abort(404);

    // أنشئ كائن Assignment مؤقت واربطه بالدرس
    $assignment = new Assignment();
    $assignment->lesson()->associate($lesson);

    // تحقق من الصلاحية
    $this->authorize('create', $assignment);

    return view('assignments.create', compact('course','lesson'));
}


public function store(AssignmentRequest $request, Course $course, Lesson $lesson)
{
    if ($lesson->course_id !== $course->id) {
        abort(404);
    }

    // أنشئ كائن Assignment مؤقت للتحقق من الصلاحية
    $assignment = new Assignment();
    $assignment->lesson()->associate($lesson);

    // استخدم authorize العادي بعد تعديل البوليسي
    $this->authorize('create', $assignment);

    $data = $request->validated();
    $data['lesson_id'] = $lesson->id;
    $data['instructor_id'] = auth()->id();

    Assignment::create($data);

    return redirect()->route('courses.lessons.assignments.index', [$course, $lesson])
                    ->with('success','Assignment created successfully.');
}




    public function show(Course $course, Lesson $lesson, Assignment $assignment)
    {
        if ($assignment->lesson_id !== $lesson->id || $lesson->course_id !== $course->id) abort(404);

        $assignment->load('submissions.student');
        return view('assignments.show', compact('course','lesson','assignment'));
    }

    public function edit(Course $course, Lesson $lesson, Assignment $assignment)
    {
        if ($assignment->lesson_id !== $lesson->id || $lesson->course_id !== $course->id) abort(404);

        $this->authorize('update', $assignment);
        return view('assignments.edit', compact('course','lesson','assignment'));
    }

    public function update(AssignmentRequest $request, Course $course, Lesson $lesson, Assignment $assignment)
    {
        if ($assignment->lesson_id !== $lesson->id || $lesson->course_id !== $course->id) abort(404);

        $this->authorize('update', $assignment);

        $assignment->update($request->validated());

        return redirect()->route('courses.lessons.assignments.index', [$course,$lesson])
            ->with('success','Assignment updated successfully.');
    }

    public function destroy(Course $course, Lesson $lesson, Assignment $assignment)
    {
        if ($assignment->lesson_id !== $lesson->id || $lesson->course_id !== $course->id) abort(404);

        $this->authorize('delete', $assignment);

        $assignment->delete();

        return redirect()->route('courses.lessons.assignments.index', [$course,$lesson])
            ->with('success','Assignment deleted.');
    }
}
