@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Submissions</h1>

<form method="GET" class="mb-6 flex space-x-4">
    <select name="status" class="border p-2 rounded">
        <option value="">-- Filter by Status --</option>
        <option value="submitted" {{ request('status')=='submitted'?'selected':'' }}>Submitted</option>
        <option value="graded" {{ request('status')=='graded'?'selected':'' }}>Graded</option>
    </select>

    <select name="course_id" class="border p-2 rounded">
        <option value="">-- Filter by Course --</option>
        @foreach($courses as $course)
            <option value="{{ $course->id }}" {{ request('course_id')==$course->id?'selected':'' }}>
                {{ $course->title }}
            </option>
        @endforeach
    </select>

    <select name="lesson_id" class="border p-2 rounded">
        <option value="">-- Filter by Lesson --</option>
        @foreach($lessons as $lesson)
            <option value="{{ $lesson->id }}" {{ request('lesson_id')==$lesson->id?'selected':'' }}>
                {{ $lesson->title }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
</form>

<table class="w-full border">
    <thead>
        <tr class="bg-gray-100">
            <th class="p-2">Student</th>
            <th class="p-2">Assignment</th>
            <th class="p-2">Lesson</th>
            <th class="p-2">Course</th>
            <th class="p-2">Status</th>
            <th class="p-2">Grade</th>
            <th class="p-2">Submitted At</th>
        </tr>
    </thead>
    <tbody>
        @forelse($submissions as $submission)
            <tr>
                <td class="p-2">{{ $submission->student->name }}</td>
                <td class="p-2">{{ $submission->assignment->title }}</td>
                <td class="p-2">{{ $submission->assignment->lesson->title }}</td>
                <td class="p-2">{{ $submission->assignment->lesson->course->title }}</td>
                <td class="p-2">{{ ucfirst($submission->status) }}</td>
                <td class="p-2">{{ $submission->grade ?? '-' }}</td>
                <td class="p-2">{{ $submission->created_at->format('Y-m-d') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="p-4 text-center text-gray-500">No submissions found</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $submissions->links() }}
</div>
@endsection
