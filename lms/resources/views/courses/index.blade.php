@extends('layouts.app')

@section('title','Courses')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Courses</h1>
    @can('create', \App\Models\Course::class)
        <a href="{{ route('courses.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create Course</a>
    @endcan
</div>

<form method="GET" class="mb-4 flex gap-2">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search title..." class="border border-gray-300 px-3 py-2 rounded w-64">
    <select name="instructor_id" class="border border-gray-300 px-3 py-2 rounded">
        <option value="">All Instructors</option>
        @foreach($instructors as $ins)
        <option value="{{ $ins->id }}" {{ request('instructor_id') == $ins->id ? 'selected' : '' }}>{{ $ins->name }}</option>
        @endforeach
    </select>
    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Search</button>
</form>

<table class="w-full bg-white shadow rounded">
    <thead>
        <tr class="bg-gray-100">
            <th class="px-4 py-2 text-left">Title</th>
            <th class="px-4 py-2 text-left">Instructor</th>
            <th class="px-4 py-2 text-left">Students</th>
            <th class="px-4 py-2 text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($courses as $course)
        <tr class="border-b">
            <td class="px-4 py-2">
                <a href="{{ route('courses.show', $course) }}" class="text-blue-600 hover:underline">{{ $course->title }}</a>
            </td>
            <td class="px-4 py-2">{{ $course->instructor?->name }}</td>
            <td class="px-4 py-2">{{ $course->students->count() }}</td>
            <td class="px-4 py-2 text-right">
                @can('update', $course)
                <a href="{{ route('courses.edit', $course) }}" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 mr-2">Edit</a>
                @endcan
                @can('delete', $course)
                <form id="deleteForm{{ $course->id }}" action="{{ route('courses.destroy', $course) }}" method="POST" class="inline-block">
                    @csrf @method('DELETE')
                    <button type="button" onclick="showDeleteModal('{{ $course->id }}', '{{ addslashes($course->title) }}')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                </form>
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<!-- Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 items-center justify-center hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50" onclick="hideDeleteModal()"></div>
    
    <div class="relative bg-white rounded-lg shadow-xl w-96 mx-4 z-50">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            
            <h2 class="text-xl font-semibold text-gray-800 text-center mb-2">Delete Course</h2>
            <p class="text-gray-600 text-center mb-4">
                Are you sure you want to delete 
                <span id="courseTitle" class="font-medium text-red-600"></span>?
                This action cannot be undone.
            </p>
            
            <div class="flex justify-center space-x-3">
                <button onclick="hideDeleteModal()" class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                <button onclick="confirmDelete()" class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Delete</button>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $courses->links() }}
</div>
@endsection

@push('styles')
<style>
.hidden {
    display: none !important;
}

.flex {
    display: flex;
}

.fixed {
    position: fixed;
}

.absolute {
    position: absolute;
}

.relative {
    position: relative;
}

.inset-0 {
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}

.z-50 {
    z-index: 50;
}
</style>
@endpush

@push('scripts')
<script>
let currentCourseId = null;

function showDeleteModal(id, title) {
    console.log('Showing modal for:', id, title);
    currentCourseId = id;
    document.getElementById('courseTitle').textContent = '"' + title + '"';
    
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    document.body.style.overflow = 'hidden';
}

function hideDeleteModal() {
    console.log('Hiding modal');
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    
    document.body.style.overflow = 'auto';
    currentCourseId = null;
}

function confirmDelete() {
    console.log('Confirming delete for:', currentCourseId);
    if (currentCourseId) {
        document.getElementById('deleteForm' + currentCourseId).submit();
    }
}

// إغلاق Modal عند الضغط على Escape
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        hideDeleteModal();
    }
});

// التأكد من أن الـ Modal مخفي عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded, hiding modal');
    hideDeleteModal(); // تأكد من إخفاء الـ Modal عند التحميل
});
</script>
@endpush