@extends('layouts.app')
@section('title', "Edit Lesson: {$lesson->title}")

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Edit Lesson: {{ $lesson->title }}</h1>
    @include('partials.flash')
</div>

<form action="{{ route('courses.lessons.update', [$course, $lesson]) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    @method('PUT')
    @include('lessons._form', ['lesson' => $lesson, 'buttonText' => 'Update Lesson'])
</form>
@endsection
