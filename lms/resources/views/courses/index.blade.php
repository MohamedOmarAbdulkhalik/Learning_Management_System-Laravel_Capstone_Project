@extends('layouts.app')

@section('title','Courses')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Courses</h1>
    @can('create', \App\Models\Course::class)
        <a href="{{ route('courses.create') }}" class="btn">Create Course</a>
    @endcan
    </div>

    <form method="GET" class="mb-4">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search title..." class="input">
    <select name="instructor_id" class="input">
        <option value="">All Instructors</option>
        @foreach($instructors as $ins)
        <option value="{{ $ins->id }}" {{ request('instructor_id') == $ins->id ? 'selected' : '' }}>{{ $ins->name }}</option>
        @endforeach
    </select>
    <button class="btn">Search</button>
    </form>

    <table class="w-full bg-white shadow rounded">
    <thead>
        <tr>
        <th>Title</th>
        <th>Instructor</th>
        <th>Students</th>
        <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($courses as $course)
        <tr>
        <td><a href="{{ route('courses.show', $course) }}">{{ $course->title }}</a></td>
        <td>{{ $course->instructor?->name }}</td>
        <td>{{ $course->students->count() }}</td>
        <td class="text-right">
            @can('update', $course)
            <a href="{{ route('courses.edit', $course) }}" class="btn">Edit</a>
            @endcan
            @can('delete', $course)
            <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this course?')">
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
    {{ $courses->links() }}
</div>
@endsection
