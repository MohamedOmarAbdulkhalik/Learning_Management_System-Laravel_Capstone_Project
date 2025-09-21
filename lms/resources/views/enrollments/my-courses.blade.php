@extends('layouts.app')
@section('title', 'My Courses')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold mb-2 text-gray-900 dark:text-gray-100">My Courses</h1>
    <p class="text-gray-600 dark:text-gray-400 mb-4">Courses you are currently enrolled in</p>

    @include('partials.flash')
</div>

<div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
    @forelse($courses as $course)
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 flex flex-col justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1">{{ $course->title }}</h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Instructor: {{ $course->instructor?->name ?? 'N/A' }}</p>
        </div>

        <div class="mt-4">
            <x-button-link href="{{ route('courses.lessons.index', $course) }}" variant="primary" full>
                View Lessons
            </x-button-link>
        </div>
    </div>
    @empty
        <p class="text-gray-500 dark:text-gray-400 col-span-full text-center">You are not enrolled in any courses.</p>
    @endforelse
</div>

<div class="mt-6">
    {{ $courses->links() }}
</div>
@endsection
