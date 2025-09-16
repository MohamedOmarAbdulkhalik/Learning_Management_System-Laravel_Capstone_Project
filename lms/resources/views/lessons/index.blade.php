@extends('layouts.app')

@section('title', "Lessons of {$course->title}")

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Lessons: {{ $course->title }}</h1>
    <div>
        <a href="{{ route('courses.index') }}" class="btn">Back to Course</a>
        @can('create', [App\Models\Lesson::class, $course])
            <a href="{{ route('courses.lessons.create', $course) }}" class="btn ml-2">Create Lesson</a>
        @endcan
    </div>
</div>

@include('partials.flash')

<table class="w-full bg-white shadow rounded">
    <thead>
        <tr>
            <th>Title</th>
            <th>Assignments</th>
            <th>Resource</th>
            <th></th>
        </tr>
    </thead>


    <tbody>
        @foreach($lessons as $lesson)
            <tr>
                <td><a href="{{ route('courses.lessons.show', [$course, $lesson]) }}">{{ $lesson->title }}</a></td>
                <td>{{ $lesson->assignments_count }}</td>
                <td>
                    @if($lesson->resource_path)
                        <a href="{{ Storage::url($lesson->resource_path) }}" target="_blank" class="underline">Download</a>
                    @else
                        -
                    @endif
                </td>
                <td class="text-right">
                    @can('update', $lesson)
                        <a href="{{ route('courses.lessons.edit', [$course, $lesson]) }}" class="btn">Edit</a>
                    @endcan
                    @can('delete', $lesson)
                        <form action="{{ route('courses.lessons.destroy', [$course, $lesson]) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this lesson?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    @endcan
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $lessons->links() }}
</div>
@endsection
