@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-6">Instructor Dashboard</h1>

{{-- My Courses --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    @foreach($courses as $course)
    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 text-center">
        <div class="w-16 h-16 mx-auto flex items-center justify-center rounded-full bg-gradient-to-r from-green-500 to-blue-600 text-white text-2xl font-bold shadow-lg mb-4 animate-float">
            {{ substr($course->title, 0, 1) }}
        </div>
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ $course->title }}</h2>
        <p class="text-gray-700 dark:text-gray-200">{{ $course->lessons->count() }} Lessons</p>
        {{-- Action button example --}}
        <x-button-link href="{{ route('courses.show', $course) }}" class="mt-3 w-full" variant="primary">
            View Course
        </x-button-link>
    </div>
    @endforeach
</div>

{{-- Assignments Status Chart --}}
<div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4 mb-6">
    <h2 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-100">Assignments Status</h2>
    <div id="vue-app" class="h-64 md:h-48">
        <assignments-status-chart 
            :labels='@json($chartLabels)'
            :submitted='@json($submittedCounts)'
            :graded='@json($gradedCounts)'>
        </assignments-status-chart>
    </div>
</div>

{{-- Latest Student Activities --}}
<div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4">
    <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Latest Student Activities</h2>
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b border-gray-300 dark:border-gray-700">
                <th class="p-3 text-gray-700 dark:text-gray-300">Student</th>
                <th class="p-3 text-gray-700 dark:text-gray-300">Action</th>
                <th class="p-3 text-gray-700 dark:text-gray-300">At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                <td class="p-3 text-gray-800 dark:text-gray-200">{{ $activity->student->name }}</td>
                <td class="p-3 text-gray-800 dark:text-gray-200">{{ $activity->description }}</td>
                <td class="p-3 text-gray-800 dark:text-gray-200">{{ $activity->created_at->diffForHumans() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
