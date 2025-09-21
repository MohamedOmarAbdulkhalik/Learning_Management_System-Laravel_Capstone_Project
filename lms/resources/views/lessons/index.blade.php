@extends('layouts.app')

@section('title', "Lessons of {$course->title}")

@section('content')
<div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-2">{{ $course->title }}</h1>
    <p class="text-gray-700 dark:text-gray-300 mb-1">Description: {{ $course->description ?? 'No description available.' }}</p>
    <p class="text-gray-700 dark:text-gray-300 mb-1">Instructor: {{ $course->instructor->name ?? 'N/A' }}</p>
    <p class="text-gray-700 dark:text-gray-300">Enrolled Students: {{ $course->students()->count() }}</p>

    {{-- أزرار التسجيل للطلاب فقط --}}
    @if(auth()->check() && auth()->user()->role === 'student')
        @if($course->students->contains(auth()->id()))
            <form action="{{ route('courses.unenroll', $course) }}" method="POST" class="inline-block mt-2">
                @csrf
                @method('DELETE')
                <x-button variant="danger" type="submit">Unenroll</x-button>
            </form>
        @else
            <form action="{{ route('courses.enroll', $course) }}" method="POST" class="inline-block mt-2">
                @csrf
                <x-button variant="primary" type="submit">Enroll</x-button>
            </form>
        @endif
    @endif
</div>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
    <h2 class="text-xl font-semibold">Lessons</h2>
    <div class="flex flex-wrap gap-2">
        <x-button-link href="{{ route('courses.index') }}" variant="danger">Back to Courses</x-button-link>

        {{-- زر إنشاء درس يظهر فقط للمدرّب صاحب الكورس أو الأدمن --}}
        @can('manageLessons', $course)
            <x-button-link variant="primary" href="{{ route('courses.lessons.create', $course) }}">Create Lesson</x-button-link>
        @endcan
    </div>
</div>

@include('partials.flash')

{{-- جدول الدروس --}}
<div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Title</th>
                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Assignments</th>
                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Resource</th>
                <th class="px-4 py-2 text-right text-gray-700 dark:text-gray-200">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($lessons as $lesson)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-4 py-2">
                        @if(auth()->check() && (
                            $course->students->contains(auth()->id()) 
                            || auth()->user()->id === $course->instructor_id 
                            || auth()->user()->role === 'admin'
                        ))
                            <x-button-link href="{{ route('courses.lessons.show', [$course, $lesson]) }}" variant="secondary">
                                {{ $lesson->title }}
                            </x-button-link>
                        @else
                            <span class="text-gray-500 dark:text-gray-400">{{ $lesson->title }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $lesson->assignments_count }}</td>
                    <td class="px-4 py-2">
                        @if($lesson->resource_path)
                            <x-button-link href="{{ Storage::url($lesson->resource_path) }}" target="_blank" variant="secondary">
                                Download
                            </x-button-link>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 py-2 text-right flex flex-wrap justify-end gap-2">
                        @can('manageLessons', $course)
                            <x-button-link href="{{ route('courses.lessons.assignments.index', [$course, $lesson]) }}" variant="purple">Manage Assignment</x-button-link>
                            <form action="{{ route('courses.lessons.destroy', [$course, $lesson]) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this lesson?')">
                                @csrf @method('DELETE')
                                <x-button-link href="{{ route('courses.lessons.edit', [$course, $lesson]) }}" variant="green">Edit</x-button-link>
                                <x-button variant="danger" type="submit">Delete</x-button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500 dark:text-gray-400">No lessons found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $lessons->links() }}
</div>
@endsection
