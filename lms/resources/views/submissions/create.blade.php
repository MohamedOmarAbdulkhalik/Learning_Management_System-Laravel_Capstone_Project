@extends('layouts.app')
@section('content')
<h1>Submit Assignment: {{ $assignment->title }}</h1>

<form action="{{ route('assignments.submissions.store', [$course,$lesson,$assignment]) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="block font-medium">Your Answer</label>
        <textarea name="content" class="form-input w-full"></textarea>
    </div>

    <div class="mb-3">
        <label class="block font-medium">Upload File (optional)</label>
        <input type="file" name="file" class="form-input">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{ route('courses.lessons.show', [$course,$lesson]) }}" class="btn">Cancel</a>
</form>
@endsection
