{{-- Edit Course --}}
@extends('layouts.app')
@section('title', 'Edit Course')
@section('content')
<h2 class="text-2xl font-bold mb-4">Edit Course</h2>
<form action="{{ route('courses.update', $course) }}" method="POST">
    @method('PUT')
    @include('courses._form', ['course' => $course, 'buttonText' => 'Update Course'])
</form>
@endsection
