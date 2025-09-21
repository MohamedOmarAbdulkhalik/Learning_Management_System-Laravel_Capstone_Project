@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto p-4 space-y-6">

    {{-- Assignment Info --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-2 text-gray-900 dark:text-gray-100">{{ $assignment->title }}</h1>
        <p class="text-gray-700 dark:text-gray-200 mb-2">{{ $assignment->description }}</p>
        <p class="text-gray-600 dark:text-gray-400">Due: {{ $assignment->due_date ?? 'No due date' }}</p>
    </div>

    @include('partials.flash')

    {{-- Student Submission Form --}}
    @auth
        @if(auth()->user()->role === 'student')
            @php
                $mySubmission = $assignment->submissions->where('student_id', auth()->id())->first();
            @endphp

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                @if(!$mySubmission)
                    <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Submit Your Assignment</h2>
                    <form action="{{ route('assignments.submissions.store', $assignment) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block font-medium mb-1 text-gray-700 dark:text-gray-200">Text Answer</label>
                            <textarea name="content" class="input w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-400 rounded" rows="4"></textarea>
                        </div>
                        <div>
                            <label class="block font-medium mb-1 text-gray-700 dark:text-gray-200">File (optional)</label>
                            <input type="file" name="file" class="input w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-400 rounded" />
                        </div>
                        <x-button type="submit" variant="primary">Submit</x-button>
                    </form>
                @else
                    <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded space-y-2">
                        <p><strong>Status:</strong> {{ $mySubmission->status }}</p>
                        <p><strong>Grade:</strong> {{ $mySubmission->grade ?? '-' }}</p>
                        <p><strong>Feedback:</strong> {{ $mySubmission->feedback ?? '-' }}</p>
                        @if($mySubmission->file_path)
                            <p><a href="{{ Storage::url($mySubmission->file_path) }}" target="_blank" class="text-blue-600 dark:text-blue-400 underline">Download your file</a></p>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    @endauth

    {{-- All Submissions for Instructors --}}
    @can('grade', $assignment->submissions->first() ?? null)
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow overflow-x-auto">
            <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">All Submissions</h2>
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="p-3 text-left">Student</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Grade</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignment->submissions as $submission)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="p-3 text-gray-800 dark:text-gray-100">{{ $submission->student->name }}</td>
                            <td class="p-3 text-gray-800 dark:text-gray-100">{{ $submission->status }}</td>
                            <td class="p-3 text-gray-800 dark:text-gray-100">{{ $submission->grade ?? '-' }}</td>
                            <td class="p-3 text-right flex flex-wrap justify-end gap-2">
                                <x-button-link href="{{ route('submissions.show', $submission) }}" variant="green" size="sm">View</x-button-link>
                                <form action="{{ route('submissions.grade', $submission) }}" method="POST" class="flex flex-wrap gap-2 items-center">
                                    @csrf
                                    <input type="number" name="grade" placeholder="Grade" min="0" max="100" class="input w-24 bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-400 rounded">
                                    <input type="text" name="feedback" placeholder="Feedback" class="input w-48 bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-400 rounded">
                                    <x-button type="submit" variant="success" size="sm">Save</x-button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500 dark:text-gray-300">No submissions yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endcan

</div>
@endsection
