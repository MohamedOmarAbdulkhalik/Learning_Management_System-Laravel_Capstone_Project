@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Submission Details</h1>

@include('partials.flash')

<div class="border p-4 rounded bg-gray-50 mb-6">
    <p><strong>Student:</strong> {{ $submission->student->name }}</p>
    <p><strong>Assignment:</strong> {{ $submission->assignment->title }}</p>
    <p><strong>Lesson:</strong> {{ $submission->assignment->lesson->title }}</p>
    <p><strong>Course:</strong> {{ $submission->assignment->lesson->course->title }}</p>
    <p><strong>Status:</strong> {{ ucfirst($submission->status) }}</p>
    <p><strong>Submitted At:</strong> {{ $submission->created_at->format('Y-m-d H:i') }}</p>
</div>

@if($submission->content)
    <div class="mb-6">
        <h2 class="text-lg font-semibold">Answer:</h2>
        <p class="p-3 border rounded bg-white">{{ $submission->content }}</p>
    </div>
@endif

@if($submission->file_path)
    <div class="mb-6">
        <h2 class="text-lg font-semibold">Attachment:</h2>
        <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="text-blue-600 underline">Download File</a>
    </div>
@endif

{{-- ✅ التصحيح (للأستاذ أو المدير) --}}
@can('grade', $submission)
    <div class="border p-4 rounded bg-white">
        <h2 class="text-lg font-semibold mb-2">Grade Submission</h2>
        <form method="POST" action="{{ route('submissions.grade', $submission) }}">
            @csrf
            <div class="mb-3">
                <label for="grade" class="block font-medium">Grade</label>
                <input type="number" name="grade" id="grade" class="border p-2 w-32"
                       value="{{ old('grade', $submission->grade) }}" min="0" max="100">
            </div>
            <div class="mb-3">
                <label for="feedback" class="block font-medium">Feedback</label>
                <textarea name="feedback" id="feedback" class="border p-2 w-full">{{ old('feedback', $submission->feedback) }}</textarea>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Grade</button>
        </form>
    </div>
@endcan

{{-- ✅ الطالب يشوف درجته فقط --}}
@cannot('grade', $submission)
    @if($submission->grade !== null)
        <div class="border p-4 rounded bg-green-50 mt-6">
            <h2 class="text-lg font-semibold">Your Grade</h2>
            <p><strong>Grade:</strong> {{ $submission->grade }}</p>
            <p><strong>Feedback:</strong> {{ $submission->feedback ?? 'No feedback' }}</p>
        </div>
    @endif
@endcannot

<a href="{{ route('submissions.index') }}" class="mt-6 inline-block bg-gray-600 text-white px-4 py-2 rounded">Back to Submissions</a>
@endsection
