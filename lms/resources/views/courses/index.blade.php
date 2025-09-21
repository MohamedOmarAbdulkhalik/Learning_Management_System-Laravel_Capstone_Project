@extends('layouts.app')

@section('title','Courses')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
    <h1 class="text-2xl font-bold">Courses</h1>
    @can('create', \App\Models\Course::class)
        <x-button-link href="{{ route('courses.create') }}" variant="primary">Create Course</x-button-link>
    @endcan
</div>

@include('partials.flash')

<form method="GET" class="mb-4 flex flex-col sm:flex-row gap-2">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search title..." class="border border-gray-300 dark:border-gray-600 px-3 py-2 rounded w-full sm:w-64">
    <select name="instructor_id" class="border border-gray-300 dark:border-gray-600 px-3 py-2 rounded w-full sm:w-auto">
        <option value="">All Instructors</option>
        @foreach($instructors as $ins)
        <option value="{{ $ins->id }}" {{ request('instructor_id') == $ins->id ? 'selected' : '' }}>{{ $ins->name }}</option>
        @endforeach
    </select>
    <x-button type="submit" variant="primary">Search</x-button>
</form>

<div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Title</th>
                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Instructor</th>
                <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Students</th>
                <th class="px-4 py-2 text-right text-gray-700 dark:text-gray-200">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($courses as $course)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-4 py-2">
                        <x-button-link href="{{ route('courses.lessons.index', $course) }}" variant="secondary">
                            {{ $course->title }}
                        </x-button-link>
                    </td>
                    <td class="px-4 py-2">{{ $course->instructor?->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $course->students->count() }}</td>
                    <td class="px-4 py-2 text-right flex flex-wrap justify-end gap-2">
                        @can('manage-enrollments', $course)
                            <x-button-link href="{{ route('courses.students.manage', $course) }}" variant="purple">Manage Students</x-button-link>
                        @endcan
                        @can('update', $course)
                            <x-button-link href="{{ route('courses.edit', $course) }}" variant="green">Edit</x-button-link>
                        @endcan
                        @can('delete', $course)
                            <form id="deleteForm{{ $course->id }}" action="{{ route('courses.destroy', $course) }}" method="POST" class="inline-block">
                                @csrf @method('DELETE')
                                <x-button type="button" variant="danger" onclick="showDeleteModal('{{ $course->id }}', '{{ addslashes($course->title) }}')">Delete</x-button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 items-center justify-center hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50" onclick="hideDeleteModal()"></div>
    
    <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl w-96 mx-4 z-50">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 text-center mb-2">Delete Course</h2>
            <p class="text-gray-600 dark:text-gray-300 text-center mb-4">
                Are you sure you want to delete 
                <span id="courseTitle" class="font-medium text-red-600"></span>?
                This action cannot be undone.
            </p>
            
            <div class="flex justify-center space-x-3 flex-wrap gap-2">
                <x-button variant="secondary" onclick="hideDeleteModal()">Cancel</x-button>
                <x-button variant="danger" onclick="confirmDelete()">Delete</x-button>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $courses->links() }}
</div>
@endsection

@push('scripts')
<script>
let currentCourseId = null;

function showDeleteModal(id, title) {
    currentCourseId = id;
    document.getElementById('courseTitle').textContent = '"' + title + '"';
    
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    document.body.style.overflow = 'hidden';
}

function hideDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    
    document.body.style.overflow = 'auto';
    currentCourseId = null;
}

function confirmDelete() {
    if (currentCourseId) {
        document.getElementById('deleteForm' + currentCourseId).submit();
    }
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        hideDeleteModal();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    hideDeleteModal();
});
</script>
@endpush
