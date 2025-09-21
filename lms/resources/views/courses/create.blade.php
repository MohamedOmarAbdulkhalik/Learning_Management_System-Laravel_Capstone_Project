{{-- Create Course --}}
@extends('layouts.app')
@section('title', 'Create Course')
@section('content')
<h2 class="text-2xl font-bold mb-4">Create Course</h2>
<form action="{{ route('courses.store') }}" method="POST">
    @include('courses._form', ['buttonText' => 'Create Course'])
</form>
@endsection
