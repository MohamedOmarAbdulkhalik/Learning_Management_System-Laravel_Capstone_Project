@csrf
<div class="space-y-6">

    {{-- Title --}}
    <div>
        <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Title</label>
        <input type="text" name="title" value="{{ old('title', $lesson->title ?? '') }}" 
               class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                      bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 
                      focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" 
               required>
        @error('title') <p class="text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Content --}}
    <div>
        <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Content</label>
        <textarea name="content" rows="5" 
                  class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                         bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 
                         focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">{{ old('content', $lesson->content ?? '') }}</textarea>
        @error('content') <p class="text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Resource --}}
    <div>
        <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Resource (PDF, Doc, Video)</label>
        <input type="file" name="resource" 
               class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                      bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 
                      focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
        @if(!empty($lesson->resource_path))
            <p class="text-sm mt-1 text-gray-600 dark:text-gray-300">
                Current: 
                <x-button-link href="{{ Storage::url($lesson->resource_path) }}" target="_blank" variant="secondary" class="px-2 py-1 text-sm">
                    Open resource
                </x-button-link>
            </p>
        @endif
        @error('resource') <p class="text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Buttons --}}
    <div class="flex flex-wrap gap-3 mt-4">
        <x-button type="submit" variant="primary">{{ $buttonText ?? 'Save' }}</x-button>
        <x-button-link href="{{ route('courses.lessons.index', $course) }}" variant="secondary">Cancel</x-button-link>
    </div>

</div>
