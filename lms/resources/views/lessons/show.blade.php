@extends('layouts.app')
@section('title', $lesson->title)

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $lesson->title }}</h1>
    <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $lesson->content }}</p>

    @if($lesson->resource_path)
        <x-button-link href="{{ Storage::url($lesson->resource_path) }}" target="_blank" variant="secondary" class="mb-4">
            Open Resource
        </x-button-link>
    @endif

    {{-- زر إضافة تكليف للمدرب أو الأدمن --}}
    @can('manageLessons', $course)
        <div class="mb-6">
            <x-button-link href="{{ route('courses.lessons.assignments.create', [$course, $lesson]) }}" variant="primary">
                Add Assignment
            </x-button-link>
        </div>
    @endcan
</div>

{{-- قائمة التكليفات --}}
<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-3">Assignments</h2>

    <ul class="space-y-3">
        @forelse($lesson->assignments as $assignment)
            <li class="flex flex-col md:flex-row md:justify-between md:items-center p-3 border rounded-lg bg-gray-50 dark:bg-gray-700">
                <div class="text-gray-800 dark:text-gray-200">
                    {{ $assignment->title }}
                </div>

                <div class="mt-2 md:mt-0 flex gap-2 items-center">
                    @auth
                        @can('submit', $assignment)
                            @php
                                $submission = $assignment->submissions()->where('student_id', auth()->id())->first();
                            @endphp

                            @if(!$submission)
                                <x-button-link href="{{ route('assignments.submissions.create', [$course, $lesson, $assignment]) }}" variant="success">
                                    Submit
                                </x-button-link>
                            @else
                                <span class="text-green-600 dark:text-green-400 text-sm">
                                    Status: {{ ucfirst($submission->status) }}
                                    @if($submission->grade)
                                        | Grade: {{ $submission->grade }}
                                    @endif
                                </span>
                            @endif
                        @endcan
                    @endauth
                </div>
            </li>
        @empty
            <li class="text-gray-500 dark:text-gray-400 text-center">No assignments yet.</li>
        @endforelse
    </ul>
</div>

<div class="mt-6">
    <x-button-link href="{{ route('courses.lessons.index', $course) }}" variant="secondary">
        Back to Lessons
    </x-button-link>
</div>
@endsection
