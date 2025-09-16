<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // الطالب يرى كورساته
// 1. اتبع auth() helper
    public function myCourses()
    {
        $courses = Auth::user()->courses()->with('instructor')->paginate(10);
        return view('enrollments.my_courses', compact('courses'));
    }

    // يطلب الطالب التسجيل في الكورس
    public function store(Course $course, Request $request)
    {
        $this->authorize('enroll', $course);

        $studentId = Auth::id();

        // امنع التكرار
        if ($course->students()->where('student_id', $studentId)->exists()) {
            return redirect()->back()->with('error', 'أنت مسجل بالفعل في هذا الكورس.');
        }

        $course->students()->attach($studentId);

        return redirect()->back()->with('success', 'تم التسجيل في الكورس بنجاح.');
    }

    // يلغي الطالب تسجيله
    public function destroy(Course $course)
    {
        $this->authorize('enroll', $course);

        $studentId = Auth::id();

        $course->students()->detach($studentId);

        return redirect()->back()->with('success', 'تم إلغاء التسجيل.');
    }

    // Admin/Instructor: عرض قائمة الطلاب المسجلين بالكورس وإضافة طالب يدويًا
    public function manage(Course $course)
    {
        $this->authorize('manage-enrollments', $course);

        $students = $course->students()->paginate(15);
        // قائمة كل الطلاب المتاحين للإضافة (exclude already enrolled)
        $available = \App\Models\User::where('role','student')
                        ->whereNotIn('id', $course->students()->pluck('users.id'))->get();

        return view('enrollments.manage', compact('course','students','available'));
    }

    // Admin/Instructor: أضف طالب للكورس (by id)
    public function addStudent(Request $request, Course $course)
    {
        $this->authorize('manage-enrollments', $course);

        $request->validate(['student_id' => 'required|exists:users,id']);

        $studentId = $request->input('student_id');

        if ($course->students()->where('student_id', $studentId)->exists()) {
            return redirect()->back()->with('error','الطالب مسجل بالفعل.');
        }

        $course->students()->attach($studentId);

        return redirect()->back()->with('success','تم إضافة الطالب للكورس.');
    }

    // Admin/Instructor: إزالة طالب معين
    public function removeStudent(Course $course, User $student)
    {
        $this->authorize('manage-enrollments', $course);

        $course->students()->detach($student->id);

        return redirect()->back()->with('success','تم إزالة الطالب.');
    }
}
