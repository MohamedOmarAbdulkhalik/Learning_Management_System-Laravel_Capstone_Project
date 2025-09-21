@extends('layouts.app')

@section('title', "Create Assignment for {$lesson->title}")

@section('content')
<div class="max-w-lg mx-auto p-6 rounded-lg shadow bg-white dark:bg-gray-800">
    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Create Assignment for: {{ $lesson->title }}</h1>

    <form action="{{ route('courses.lessons.assignments.store', [$course, $lesson]) }}" method="POST" class="space-y-5">
        @csrf

        {{-- Title --}}
        <div>
            <label class="block font-medium mb-2 text-gray-700 dark:text-gray-200">Title</label>
            <input 
                type="text" 
                name="title" 
                placeholder="Enter assignment title"
                class="w-full px-4 py-2 border rounded-lg bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                required
            >
        </div>

        {{-- Description --}}
        <div>
            <label class="block font-medium mb-2 text-gray-700 dark:text-gray-200">Description</label>
            <textarea 
                name="description" 
                placeholder="Enter assignment description"
                rows="4"
                class="w-full px-4 py-2 border rounded-lg bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
            ></textarea>
        </div>

        {{-- Due Date --}}
        <div>
            <label class="block font-medium mb-2 text-gray-700 dark:text-gray-200">Due Date</label>
            <input 
                type="date" 
                name="due_date" 
                class="w-full px-4 py-2 border rounded-lg bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
            >
        </div>

        {{-- Buttons --}}
        <div class="flex flex-wrap gap-3 mt-4">
            <x-button type="submit" variant="success">Save Assignment</x-button>
            <x-button-link href="{{ route('courses.lessons.show', [$course,$lesson]) }}" variant="secondary">Cancel</x-button-link>
        </div>
    </form>
</div>
@endsection
