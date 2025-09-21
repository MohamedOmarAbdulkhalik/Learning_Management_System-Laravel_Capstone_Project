@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto p-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Assignments for: {{ $lesson->title }}</h1>

        @can('manageLessons', $course)
            <x-button-link href="{{ route('courses.lessons.assignments.create', [$course,$lesson]) }}" variant="primary">
                Create Assignment
            </x-button-link>
        @endcan
    </div>

    @include('partials.flash')

    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <th class="p-3 text-left">Title</th>
                    <th class="p-3 text-left">Due Date</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assignments as $assignment)
                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="p-3">
                            <a href="{{ route('courses.lessons.assignments.show', [$course,$lesson,$assignment]) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                {{ $assignment->title }}
                            </a>
                        </td>
                        <td class="p-3">
                            {{ $assignment->due_date ? $assignment->due_date->format('Y-m-d') : '-' }}
                        </td>
                        <td class="p-3 text-right flex flex-wrap justify-end gap-2">
                            <x-button-link href="{{ route('courses.lessons.assignments.show', [$course,$lesson,$assignment]) }}" variant="green" size="sm">
                                View
                            </x-button-link>

                            @can('update', $assignment)
                                <x-button-link href="{{ route('courses.lessons.assignments.edit', [$course,$lesson,$assignment]) }}" variant="purple" size="sm">
                                    Edit
                                </x-button-link>
                            @endcan

                            @can('delete', $assignment)
                                <form action="{{ route('courses.lessons.assignments.destroy', [$course,$lesson,$assignment]) }}" method="POST" onsubmit="return confirm('Delete this assignment?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger" size="sm">Delete</x-button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500 dark:text-gray-300">
                            No assignments found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $assignments->links() }}
    </div>
</div>
@endsection
