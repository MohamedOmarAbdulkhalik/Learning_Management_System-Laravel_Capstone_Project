@extends('layouts.app')

@section('content')
<div id="dashboard-app">
    <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

    {{-- Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 text-center">
            <div class="w-16 h-16 mx-auto flex items-center justify-center rounded-full bg-gradient-to-r from-green-500 to-blue-600 text-white text-2xl font-bold shadow-lg mb-4 animate-float">
                S
            </div>
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">Students</h2>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-200">{{ $studentsCount }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 text-center">
            <div class="w-16 h-16 mx-auto flex items-center justify-center rounded-full bg-gradient-to-r from-green-500 to-blue-600 text-white text-2xl font-bold shadow-lg mb-4 animate-float">
                C
            </div>
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">Courses</h2>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-200">{{ $coursesCount }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 text-center">
            <div class="w-16 h-16 mx-auto flex items-center justify-center rounded-full bg-gradient-to-r from-green-500 to-blue-600 text-white text-2xl font-bold shadow-lg mb-4 animate-float">
                A
            </div>
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">Assignments</h2>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-200">{{ $assignmentsCount }}</p>
        </div>
    </div>

<div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4 mb-6">
    <h2 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-100">Students per Course</h2>
    <div id="vue-app" class="h-64 md:h-48"> {{-- تحديد ارتفاع أقل --}}
        <course-distribution-chart 
            :labels='@json($chartLabels)' 
            :data='@json($chartData)'>
        </course-distribution-chart>
    </div>
</div>


    {{-- Latest Submissions --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Latest Submissions</h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-300 dark:border-gray-700">
                    <th class="p-3 text-gray-700 dark:text-gray-300">Student</th>
                    <th class="p-3 text-gray-700 dark:text-gray-300">Assignment</th>
                    <th class="p-3 text-gray-700 dark:text-gray-300">Course</th>
                    <th class="p-3 text-gray-700 dark:text-gray-300">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($latestSubmissions as $sub)
                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <td class="p-3 text-gray-800 dark:text-gray-200">{{ $sub->student->name }}</td>
                    <td class="p-3 text-gray-800 dark:text-gray-200">{{ $sub->assignment->title }}</td>
                    <td class="p-3 text-gray-800 dark:text-gray-200">{{ $sub->assignment->lesson->course->title }}</td>
                    <td class="p-3 text-gray-800 dark:text-gray-200">{{ ucfirst($sub->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
