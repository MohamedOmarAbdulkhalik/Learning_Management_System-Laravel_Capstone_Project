@extends('layouts.app')
@section('content')
<h2>Edit Lesson: {{ $lesson->title }}</h2>

<form action="{{ route('courses.lessons.update', [$course, $lesson]) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @include('lessons._form', ['lesson' => $lesson, 'buttonText' => 'Update Lesson'])
</form>
@endsection
