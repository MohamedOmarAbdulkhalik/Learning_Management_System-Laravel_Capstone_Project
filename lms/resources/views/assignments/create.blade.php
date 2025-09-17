@extends('layouts.app')

@section('title', "Create Assignment for {$lesson->title}")

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Create Assignment for: {{ $lesson->title }}</h1>

    <form action="{{ route('courses.lessons.assignments.store', [$course, $lesson]) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="block font-medium">Title</label>
            <input type="text" name="title" class="form-input w-full" required>
        </div>

        <div class="mb-3">
            <label class="block font-medium">Description</label>
            <textarea name="description" class="form-input w-full"></textarea>
        </div>

        <div class="mb-3">
            <label class="block font-medium">Due Date</label>
            <input type="date" name="due_date" class="form-input w-full">
        </div>

        <button type="submit" class="btn btn-success">Save Assignment</button>
        <a href="{{ route('courses.lessons.show', [$course,$lesson]) }}" class="btn">Cancel</a>
    </form>
</div>
@endsection
