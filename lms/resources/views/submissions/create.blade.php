@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-6">Submit Assignment: {{ $assignment->title }}</h1>

<form action="{{ route('assignments.submissions.store', [$course,$lesson,$assignment]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    {{-- Your Answer --}}
    <div>
        <label class="block font-medium text-gray-700 dark:text-gray-200 mb-1">Your Answer</label>
        <textarea name="content" rows="6"
                  class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                         bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 
                         focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"></textarea>
        @error('content') <p class="text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Upload File --}}
    <div>
        <label class="block font-medium text-gray-700 dark:text-gray-200 mb-1">Upload File (optional)</label>
        <input type="file" name="file"
               class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600
                      bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                      focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
        @error('file') <p class="text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Buttons --}}
    <div class="flex flex-wrap gap-3 mt-4">
        <x-button type="submit" variant="primary">Submit</x-button>
        <x-button-link href="{{ route('courses.lessons.show', [$course,$lesson]) }}" variant="secondary">Cancel</x-button-link>
    </div>
</form>
@endsection
