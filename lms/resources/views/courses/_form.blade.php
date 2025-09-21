{{-- resources/views/courses/_form.blade.php --}}
@csrf
<div class="flex flex-col gap-4">

    <div>
        <label for="title" class="block font-medium text-gray-700 dark:text-gray-200">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $course->title ?? '') }}" 
            class="input w-full" placeholder="Course title">
        @error('title')
            <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="block font-medium text-gray-700 dark:text-gray-200">Description</label>
        <textarea name="description" id="description" class="input w-full" placeholder="Course description">{{ old('description', $course->description ?? '') }}</textarea>
        @error('description')
            <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
        @enderror
    </div>

    @can('create', App\Models\Course::class)
    <div>
        <label for="instructor_id" class="block font-medium text-gray-700 dark:text-gray-200">Instructor</label>
        <select name="instructor_id" id="instructor_id" class="input w-full">
            <option value="">Select instructor</option>
            @foreach($instructors as $i)
                <option value="{{ $i->id }}" {{ (old('instructor_id', $course->instructor_id ?? '') == $i->id) ? 'selected' : '' }}>
                    {{ $i->name }}
                </option>
            @endforeach
        </select>
    </div>
    @endcan

    <x-button class="mt-3" type="submit">{{ $buttonText ?? 'Save' }}</x-button>

</div>
