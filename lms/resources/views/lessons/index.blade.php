@extends('layouts.app')

@section('title', "Lessons of {$course->title}")

@section('content')
<div class="mb-6 bg-white p-4 rounded shadow">
    <h1 class="text-2xl font-bold mb-2">{{ $course->title }}</h1>
    <p class="text-gray-700 mb-1">Description: {{ $course->description ?? 'No description available.' }}</p>
    <p class="text-gray-700 mb-1">Instructor: {{ $course->instructor->name ?? 'N/A' }}</p>
    <p class="text-gray-700">Enrolled Students: {{ $course->students()->count() }}</p>

    {{-- أزرار التسجيل للطلاب فقط --}}
    @if(auth()->check() && auth()->user()->role === 'student')
        @if($course->students->contains(auth()->id()))
<form action="{{ route('courses.unenroll', $course) }}" method="POST" class="inline-block mt-2">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Unenroll</button>
</form>
        @else
            <form action="{{ route('courses.enroll', $course) }}" method="POST" class="inline-block mt-2">
                @csrf
                <button type="submit" class="btn btn-success">Enroll</button>
            </form>
        @endif
    @endif
</div>

<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold">Lessons</h2>
    <div>
        <a href="{{ route('courses.index') }}" class="btn">Back to Courses</a>

        {{-- زر إنشاء درس يظهر فقط للمدرّب صاحب الكورس أو الأدمن --}}
        @can('manageLessons', $course)
            <a href="{{ route('courses.lessons.create', $course) }}" class="btn ml-2">Create Lesson</a>
        @endcan
    </div>
</div>

@include('partials.flash')

<table class="w-full bg-white shadow rounded">
    <thead>
        <tr>
            <th class="p-2 text-left">Title</th>
            <th class="p-2 text-left">Assignments</th>
            <th class="p-2 text-left">Resource</th>
            <th class="p-2"></th>
        </tr>
    </thead>

    <tbody>
        @forelse($lessons as $lesson)
            <tr class="border-b">
                <td class="p-2">
                    <a href="{{ route('courses.lessons.show', [$course, $lesson]) }}" class="text-blue-600 hover:underline">
                        {{ $lesson->title }}
                    </a>
                </td>
                <td class="p-2">{{ $lesson->assignments_count }}</td>
                <td class="p-2">
                    @if($lesson->resource_path)
                        <a href="{{ Storage::url($lesson->resource_path) }}" target="_blank" class="underline">Download</a>
                    @else
                        -
                    @endif
                </td>
                    <td class="p-2 text-right">
                        @can('manageLessons', $course)
                            <a href="{{ route('courses.lessons.edit', [$course, $lesson]) }}" class="btn">Edit</a>

                            <a href="{{ route('courses.lessons.assignments.index', [$course, $lesson]) }}" 
                            class="btn btn-success ml-2">
                            Manage Assignment
                            </a>

                            <form action="{{ route('courses.lessons.destroy', [$course, $lesson]) }}" 
                                method="POST" class="inline-block" 
                                onsubmit="return confirm('Delete this lesson?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        @endcan
                    </td>

            </tr>
        @empty
            <tr>
                <td colspan="4" class="p-4 text-center text-gray-500">No lessons found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $lessons->links() }}
</div>
@endsection
