@extends('layouts.app')
@section('content')
<h1>{{ $course->title }}</h1>
<p>{{ $course->description }}</p>
<p>Instructor: {{ $course->instructor?->name }}</p>

<h3>Lessons</h3>
<ul>
    @foreach($course->lessons as $lesson)
        <li>{{ $lesson->title }}</li>
    @endforeach
</ul>
@endsection
