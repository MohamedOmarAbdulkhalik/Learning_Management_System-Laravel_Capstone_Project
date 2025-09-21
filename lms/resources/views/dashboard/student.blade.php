@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-6">Student Dashboard</h1>

{{-- My Courses --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    @foreach($myCourses as $course)
    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 text-center">
        <div class="w-16 h-16 mx-auto flex items-center justify-center rounded-full bg-gradient-to-r from-green-500 to-blue-600 text-white text-2xl font-bold shadow-lg mb-4 animate-float">
            {{ substr($course->title, 0, 1) }}
        </div>
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ $course->title }}</h2>
        <x-button-link href="{{ route('courses.lessons.index', $course) }}" class="mt-3 w-full" variant="primary">
            View Course
        </x-button-link>
    </div>
    @endforeach
</div>

{{-- Grades Chart --}}
<div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4 mb-6">
    <h2 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-100">My Grades</h2>
    <div id="vue-app" class="h-64 md:h-48">
        <grades-chart 
            :labels='@json($chartLabels)' 
            :data='@json($chartData)'>
        </grades-chart>
    </div>
</div>

{{-- Recent Assignments --}}
<div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4">
    <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Recent Assignments</h2>
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b border-gray-300 dark:border-gray-700">
                <th class="p-3 text-gray-700 dark:text-gray-300">Assignment</th>
                <th class="p-3 text-gray-700 dark:text-gray-300">Course</th>
                <th class="p-3 text-gray-700 dark:text-gray-300">Status</th>
                <th class="p-3 text-gray-700 dark:text-gray-300">Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mySubmissions as $sub)
            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                <td class="p-3 text-gray-800 dark:text-gray-200">{{ $sub->assignment->title }}</td>
                <td class="p-3 text-gray-800 dark:text-gray-200">{{ $sub->assignment->lesson->course->title }}</td>
                <td class="p-3 text-gray-800 dark:text-gray-200">{{ ucfirst($sub->status) }}</td>
                <td class="p-3 text-gray-800 dark:text-gray-200">{{ $sub->grade ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
