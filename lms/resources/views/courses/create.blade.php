@extends('layouts.app')
@section('content')
<h2>Create Course</h2>
<form action="{{ route('courses.store') }}" method="POST">
    @include('courses._form', ['buttonText' => 'Create Course'])
</form>
@endsection
