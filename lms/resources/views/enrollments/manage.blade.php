@extends('layouts.app')

@section('title', "Manage Enrollments - {$course->title}")

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold mb-2 text-gray-900 dark:text-gray-100">
        Manage Enrollments - {{ $course->title }}
    </h1>
    <p class="text-gray-600 dark:text-gray-400">Control students enrolled in this course</p>

    @include('partials.flash')
</div>

{{-- Enrolled Students --}}
<div class="mb-6 bg-white dark:bg-gray-800 shadow rounded-lg p-4 overflow-x-auto">
    <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">Enrolled Students</h2>
    <table class="w-full table-auto border-collapse text-gray-800 dark:text-gray-200">
        <thead>
            <tr class="bg-gray-100 dark:bg-gray-700">
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Email</th>
                <th class="px-4 py-2 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($students as $s)
            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <td class="px-4 py-2">{{ $s->name }}</td>
                <td class="px-4 py-2">{{ $s->email }}</td>
                <td class="px-4 py-2 text-right">
                    <form action="{{ route('courses.students.remove', [$course, $s]) }}" method="POST" class="inline-block">
                        @csrf @method('DELETE')
                        <x-button type="submit" variant="danger" onclick="return confirm('Are you sure you want to remove this student?')">
                            Remove
                        </x-button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                    No students enrolled.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $students->links() }}
    </div>
</div>

{{-- Add Student --}}
<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
    <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">Add Student</h2>
    <form action="{{ route('courses.students.add', $course) }}" method="POST" class="flex flex-col md:flex-row gap-3 items-start md:items-end">
        @csrf
        <div class="flex-1">
            <label for="student_id" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Select Student</label>
            <select name="student_id" id="student_id" required class="input w-full dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                <option value="">Select student</option>
                @foreach($available as $a)
                    <option value="{{ $a->id }}">{{ $a->name }} ({{ $a->email }})</option>
                @endforeach
            </select>
        </div>
        <x-button type="submit" class="mt-2 md:mt-0 bg-blue-500 hover:bg-blue-600">
            Add
        </x-button>
    </form>
</div>
@endsection
