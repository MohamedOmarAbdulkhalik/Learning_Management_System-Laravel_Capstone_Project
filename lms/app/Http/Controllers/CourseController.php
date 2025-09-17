<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\CourseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function __construct()
    {
        // تتطلب أن يكون trait AuthorizesRequests موجود في Base Controller
        $this->authorizeResource(Course::class, 'course');
    }

    public function index(Request $request)
    {
        $search = $request->query('q');
        $instructor = $request->query('instructor_id');

        $courses = Course::with(['instructor','students'])
            ->when($search, fn($q) => $q->where('title','like', "%{$search}%"))
            ->when($instructor, fn($q) => $q->where('instructor_id', $instructor))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        $instructors = \App\Models\User::where('role','instructor')->get();

        return view('courses.index', compact('courses','instructors','search','instructor'));
    }

    public function create()
    {
        $instructors = \App\Models\User::where('role','instructor')->get();
        return view('courses.create', compact('instructors'));
    }

    public function store(CourseRequest $request)
    {
        $data = $request->validated();

        // إذا المستخدم مدرس فلا تسمح بتعيين instructor_id من الفورم - ضع نفسه
        if (Auth::user()->role === 'instructor') {
            $data['instructor_id'] = Auth::id();
        } else {
            $data['instructor_id'] = $data['instructor_id'] ?? Auth::id();
        }

        Course::create($data);

        return redirect()->route('courses.index')->with('success','Course created successfully.');
    }

    // TBD
    // public function show(Course $course)
    // {
    //     $course->load('lessons','instructor','students');
    //     return view('courses.show', compact('course'));
    // }

    public function edit(Course $course)
    {
        $instructors = \App\Models\User::where('role','instructor')->get();
        return view('courses.edit', compact('course','instructors'));
    }

    public function update(CourseRequest $request, Course $course)
    {
        $data = $request->validated();

        if (Auth::user()->role === 'instructor') {
            $data['instructor_id'] = $course->instructor_id;
        }

        $course->update($data);

        return redirect()->route('courses.index')->with('success','Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success','Course deleted successfully.');
    }
}
