<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Arr;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // ---------- ADMIN ----------
        if ($user->role === 'admin') {
            // fast counts
            $studentsCount = User::where('role', 'student')->count();
            $courses = Course::withCount('students')->get(); // eager count
            $coursesCount = $courses->count();
            $assignmentsCount = Assignment::count();

            // chart: students per course
            $chartLabels = $courses->pluck('title')->toArray();
            $chartData   = $courses->pluck('students_count')->map(fn($v)=> (int)$v)->toArray();

            // latest submissions (for table)
            $latestSubmissions = Submission::with(['student','assignment.lesson.course'])
                ->latest()
                ->take(10)
                ->get();

            return view('dashboard.admin', compact(
                'studentsCount','coursesCount','assignmentsCount',
                'chartLabels','chartData','latestSubmissions'
            ));
        }

        // ---------- INSTRUCTOR ----------
        if ($user->role === 'instructor') {
            // courses taught by instructor
            $courses = Course::where('instructor_id', $user->id)
                        ->with('lessons')
                        ->get();

            // Build labels (course titles)
            $chartLabels = $courses->pluck('title')->toArray();

            // For each course compute submitted / graded counts
            $submittedCounts = [];
            $gradedCounts = [];

            foreach ($courses as $course) {
                $submitted = Submission::whereHas('assignment.lesson.course', function($q) use ($course) {
                    $q->where('id', $course->id);
                })->where('status', 'submitted')->count();

                $graded = Submission::whereHas('assignment.lesson.course', function($q) use ($course) {
                    $q->where('id', $course->id);
                })->where('status', 'graded')->count();

                $submittedCounts[] = $submitted;
                $gradedCounts[] = $graded;
            }

            // latest activities = recent submissions inside instructor's courses
            $activities = Submission::with(['student','assignment.lesson.course'])
                ->whereHas('assignment.lesson.course', function($q) use ($user) {
                    $q->where('instructor_id', $user->id);
                })
                ->latest()
                ->take(12)
                ->get();

            // package chart data as arrays (two datasets)
            // we will pass labels and the two series as JSON to blade
            return view('dashboard.instructor', [
                'courses' => $courses,
                'chartLabels' => $chartLabels,
                'submittedCounts' => $submittedCounts,
                'gradedCounts' => $gradedCounts,
                'activities' => $activities,
            ]);
        }

        // ---------- STUDENT ----------
        if ($user->role === 'student') {
            // courses student is enrolled in
            $myCourses = $user->courses()->with('lessons')->get();

            // student's recent submissions for table
            $mySubmissions = $user->submissions()
                ->with(['assignment.lesson.course'])
                ->latest()
                ->take(12)
                ->get();

            // chart: student's grades over assignments (use last N graded submissions)
            $graded = $user->submissions()->whereNotNull('grade')
                ->with('assignment')->orderBy('created_at','desc')->take(12)->get();

            $chartLabels = $graded->map(fn($s)=> $s->assignment->title)->toArray();
            $chartData   = $graded->map(fn($s)=> (int)$s->grade)->toArray();

            return view('dashboard.student', compact(
                'myCourses','mySubmissions','chartLabels','chartData'
            ));
        }

        // default
        abort(403);
    }
}
