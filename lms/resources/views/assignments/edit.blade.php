@extends('layouts.app')

@section('title', "Edit Assignment: {$assignment->title}")

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Edit Assignment</h1>

    <form action="{{ route('courses.lessons.assignments.update', [$course, $lesson, $assignment]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="block font-medium">Title</label>
            <input type="text" name="title" value="{{ old('title', $assignment->title) }}" class="form-input w-full" required>
        </div>

        <div class="mb-3">
            <label class="block font-medium">Description</label>
            <textarea name="description" class="form-input w-full">{{ old('description', $assignment->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="block font-medium">Due Date</label>
            <input type="date" name="due_date" value="{{ old('due_date', $assignment->due_date ? $assignment->due_date->format('Y-m-d') : '') }}" class="form-input w-full">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('courses.lessons.assignments.index', [$course,$lesson]) }}" class="btn">Cancel</a>
    </form>
</div>
@endsection
