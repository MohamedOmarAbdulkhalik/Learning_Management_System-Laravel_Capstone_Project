@extends('layouts.app')
@section('content')
<h2>Edit Course</h2>
<form action="{{ route('courses.update', $course) }}" method="POST">
    @method('PUT')
    @include('courses._form', ['course' => $course, 'buttonText' => 'Update Course'])
</form>
@endsection
