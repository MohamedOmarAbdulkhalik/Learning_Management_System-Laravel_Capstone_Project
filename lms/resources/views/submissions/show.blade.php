@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Submission Details</h1>

@include('partials.flash')

<div class="bg-gray-50 dark:bg-gray-800 border dark:border-gray-700 p-4 rounded mb-6 space-y-1">
    <p><strong>Student:</strong> {{ $submission->student->name }}</p>
    <p><strong>Assignment:</strong> {{ $submission->assignment->title }}</p>
    <p><strong>Lesson:</strong> {{ $submission->assignment->lesson->title }}</p>
    <p><strong>Course:</strong> {{ $submission->assignment->lesson->course->title }}</p>
    <p><strong>Status:</strong> {{ ucfirst($submission->status) }}</p>
    <p><strong>Submitted At:</strong> {{ $submission->created_at->format('Y-m-d H:i') }}</p>
</div>

@if($submission->content)
<div class="mb-6">
    <h2 class="text-lg font-semibold mb-2">Answer:</h2>
    <p class="p-3 border dark:border-gray-700 rounded bg-white dark:bg-gray-700">{{ $submission->content }}</p>
</div>
@endif

@if($submission->file_path)
<div class="mb-6">
    <h2 class="text-lg font-semibold mb-2">Attachment:</h2>
    <x-button-link href="{{ Storage::url($submission->file_path) }}" target="_blank" variant="primary" size="sm">
        Download File
    </x-button-link>
</div>
@endif

{{-- ✅ التصحيح (للأستاذ أو المدير) --}}
@can('grade', $submission)
<div class="border border-gray-300 dark:border-gray-600 p-4 rounded-lg bg-white dark:bg-gray-800 shadow-sm">
    <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Grade Submission</h2>

    <form method="POST" action="{{ route('submissions.grade', $submission) }}" class="space-y-4">
        @csrf

        {{-- Grade --}}
        <div>
            <label for="grade" class="block font-medium mb-1 text-gray-700 dark:text-gray-200">Grade</label>
            <input 
                type="number" 
                name="grade" 
                id="grade" 
                class="input w-32 bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-400 rounded"
                value="{{ old('grade', $submission->grade) }}" 
                min="0" max="100"
            >
        </div>

        {{-- Feedback --}}
        <div>
            <label for="feedback" class="block font-medium mb-1 text-gray-700 dark:text-gray-200">Feedback</label>
            <textarea 
                name="feedback" 
                id="feedback" 
                class="input w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-400 rounded"
                rows="4"
            >{{ old('feedback', $submission->feedback) }}</textarea>
        </div>

        {{-- Submit Button --}}
        <x-button type="submit" variant="success">Save Grade</x-button>
    </form>
</div>
@endcan


{{-- ✅ الطالب يشوف درجته فقط --}}
@cannot('grade', $submission)
@if($submission->grade !== null)
<div class="border dark:border-gray-700 p-4 rounded bg-green-50 dark:bg-green-900 mt-6">
    <h2 class="text-lg font-semibold mb-2">Your Grade</h2>
    <p><strong>Grade:</strong> {{ $submission->grade }}</p>
    <p><strong>Feedback:</strong> {{ $submission->feedback ?? 'No feedback' }}</p>
</div>
@endif
@endcannot

<div class="mt-6">
    <x-button-link href="{{ route('submissions.index') }}" variant="secondary">Back to Submissions</x-button-link>
</div>
@endsection
