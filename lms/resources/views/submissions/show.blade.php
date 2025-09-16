@extends('layouts.app')
@section('content')
<h1>Submission by: {{ $submission->student->name }}</h1>
<p>Status: {{ $submission->status }}</p>
<p>Content: {!! nl2br(e($submission->content)) !!}</p>
@if($submission->file_path)
  <p><a href="{{ Storage::url($submission->file_path) }}" target="_blank">Download file</a></p>
@endif

@can('grade', $submission)
  <form action="{{ route('submissions.grade', $submission) }}" method="POST">
    @csrf
    <label>Grade</label>
    <input type="number" name="grade" min="0" max="100" value="{{ $submission->grade }}">
    <label>Feedback</label>
    <textarea name="feedback">{{ $submission->feedback }}</textarea>
    <button class="btn">Save grade</button>
  </form>
@endcan

@endsection
