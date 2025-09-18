<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Submission;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            // return view('dashboard.admin', [
            //     'studentsCount' => User::where('role', 'student')->count(),
            //     'coursesCount' => Course::count(),
            //     'assignmentsCount' => Assignment::count(),
            //     'latestSubmissions' => Submission::latest()->take(10)->get(),
            // ]);
                        return "admin";

        }

        if ($user->role === 'instructor') {
            // return view('dashboard.instructor', [
            //     'courses' => $user->coursesTeaching,
            //     'pendingAssignments' => Assignment::whereHas('lesson.course', fn($q) => $q->where('instructor_id', $user->id))
            //                                       ->withCount(['submissions' => fn($q) => $q->where('status','submitted')])
            //                                       ->get(),
            // ]);
                        return "instructor";

        }

        if ($user->role === 'student') {
            return view('dashboard.student', [
                'myCourses' => $user->coursesEnrolled,
                'mySubmissions' => $user->submissions()->latest()->take(10)->get(),
            ]);
            // return "student";
        }

        abort(403);
    }
}