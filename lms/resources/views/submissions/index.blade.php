@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Submissions</h1>

{{-- Filters --}}
<form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
    {{-- Status --}}
    <div>
        <label class="block text-gray-700 dark:text-gray-200 mb-1">Status</label>
        <select name="status" class="input w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200">
            <option value="">-- Filter by Status --</option>
            <option value="submitted" {{ request('status')=='submitted'?'selected':'' }}>Submitted</option>
            <option value="graded" {{ request('status')=='graded'?'selected':'' }}>Graded</option>
        </select>
    </div>

    {{-- Course --}}
    <div>
        <label class="block text-gray-700 dark:text-gray-200 mb-1">Course</label>
        <select name="course_id" class="input w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200">
            <option value="">-- Filter by Course --</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ request('course_id')==$course->id?'selected':'' }}>
                    {{ $course->title }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Lesson --}}
    <div>
        <label class="block text-gray-700 dark:text-gray-200 mb-1">Lesson</label>
        <select name="lesson_id" class="input w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200">
            <option value="">-- Filter by Lesson --</option>
            @foreach($lessons as $lesson)
                <option value="{{ $lesson->id }}" {{ request('lesson_id')==$lesson->id?'selected':'' }}>
                    {{ $lesson->title }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Filter Button --}}
    <div>
        <x-button type="submit" variant="primary" class="w-full">Filter</x-button>
    </div>
</form>

{{-- Submissions Table --}}
<div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded">
    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-100 dark:bg-gray-700">
                <th class="p-3 text-left">Student</th>
                <th class="p-3 text-left">Assignment</th>
                <th class="p-3 text-left">Lesson</th>
                <th class="p-3 text-left">Course</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-left">Grade</th>
                <th class="p-3 text-left">Submitted At</th>
                <th class="p-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($submissions as $submission)
                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="p-3">{{ $submission->student->name }}</td>
                    <td class="p-3">{{ $submission->assignment->title }}</td>
                    <td class="p-3">{{ $submission->assignment->lesson->title }}</td>
                    <td class="p-3">{{ $submission->assignment->lesson->course->title }}</td>
                    <td class="p-3">{{ ucfirst($submission->status) }}</td>
                    <td class="p-3">{{ $submission->grade ?? '-' }}</td>
                    <td class="p-3">{{ $submission->created_at->format('Y-m-d') }}</td>
                    <td class="p-3 text-right">
                        <x-button-link href="{{ route('submissions.show', $submission) }}" variant="green" size="sm">
                            View
                        </x-button-link>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="p-4 text-center text-gray-500 dark:text-gray-300">
                        No submissions found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $submissions->links() }}
</div>
@endsection
