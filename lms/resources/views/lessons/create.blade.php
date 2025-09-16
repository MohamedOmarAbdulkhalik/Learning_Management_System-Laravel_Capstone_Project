@extends('layouts.app')
@section('content')
<h2>Create Lesson for: {{ $course->title }}</h2>

<form action="{{ route('courses.lessons.store', $course) }}" method="POST" enctype="multipart/form-data">
    @include('lessons._form', ['buttonText' => 'Create Lesson'])
</form>
@endsection
