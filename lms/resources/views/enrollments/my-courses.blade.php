@extends('layouts.app')
@section('title', 'My Courses')

@section('content')
<h1>My Courses</h1>
@include('partials.flash')

<ul>
@foreach($courses as $course)
    <li>
        <a href="{{ route('courses.lessons.index', $course) }}">{{ $course->title }}</a>
        <small> — Instructor: {{ $course->instructor?->name }}</small>
    </li>
@endforeach
</ul>

{{ $courses->links() }}
@endsection
