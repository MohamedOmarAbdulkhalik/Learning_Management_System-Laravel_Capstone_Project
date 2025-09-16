@extends('layouts.app')
@section('content')
<h1>{{ $lesson->title }}</h1>
<p class="mb-4">{{ $lesson->content }}</p>

@if($lesson->resource_path)
    <a href="{{ Storage::url($lesson->resource_path) }}" target="_blank" class="btn">Open Resource</a>
@endif

<h3 class="mt-6">Assignments</h3>
<ul>
    @forelse($lesson->assignments as $assignment)
        <li>{{ $assignment->title }}</li>
    @empty
        <li>No assignments yet.</li>
    @endforelse
</ul>

<a href="{{ route('courses.lessons.index', $course) }}" class="btn mt-4">Back to lessons</a>
@endsection
