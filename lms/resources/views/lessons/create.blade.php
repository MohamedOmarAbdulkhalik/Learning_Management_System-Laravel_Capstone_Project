@extends('layouts.app')
@section('title', "Create Lesson for: {$course->title}")

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Create Lesson for: {{ $course->title }}</h1>
    @include('partials.flash')
</div>

<form action="{{ route('courses.lessons.store', $course) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    @include('lessons._form', ['buttonText' => 'Create Lesson'])
</form>
@endsection
