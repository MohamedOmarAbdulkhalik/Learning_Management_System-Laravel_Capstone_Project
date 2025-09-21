@extends('layouts.app')

@section('title', "Edit Assignment: {$assignment->title}")

@section('content')
<div class="max-w-lg mx-auto p-6 rounded-lg shadow-md bg-white dark:bg-gray-800">
    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Edit Assignment</h1>

    <form action="{{ route('courses.lessons.assignments.update', [$course, $lesson, $assignment]) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div>
            <label class="block font-medium mb-1 text-gray-700 dark:text-gray-200">Title</label>
            <input 
                type="text" 
                name="title" 
                value="{{ old('title', $assignment->title) }}" 
                class="w-full px-4 py-2 rounded-lg border-2 border-gray-400 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 
                       focus:outline-none focus:ring-2 focus:ring-blue-400" 
                required
            >
            @error('title')
                <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label class="block font-medium mb-1 text-gray-700 dark:text-gray-200">Description</label>
            <textarea 
                name="description" 
                rows="4"
                class="w-full px-4 py-2 rounded-lg border-2 border-gray-400 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200
                       focus:outline-none focus:ring-2 focus:ring-blue-400"
            >{{ old('description', $assignment->description) }}</textarea>
            @error('description')
                <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Due Date --}}
        <div>
            <label class="block font-medium mb-1 text-gray-700 dark:text-gray-200">Due Date</label>
            <input 
                type="date" 
                name="due_date" 
                value="{{ old('due_date', $assignment->due_date ? $assignment->due_date->format('Y-m-d') : '') }}" 
                class="w-full px-4 py-2 rounded-lg border-2 border-gray-400 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200
                       focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
            @error('due_date')
                <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Buttons --}}
        <div class="flex flex-wrap gap-3 mt-4">
            <x-button type="submit" variant="success">Update</x-button>
            <x-button-link href="{{ route('courses.lessons.assignments.index', [$course,$lesson]) }}" variant="secondary">Cancel</x-button-link>
        </div>
    </form>
</div>
@endsection
