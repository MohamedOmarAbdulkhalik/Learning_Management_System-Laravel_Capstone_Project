@csrf
    <div>
    <label>Title</label>
    <input type="text" name="title" value="{{ old('title', $course->title ?? '') }}" class="input">
    @error('title') <p class="text-red-500">{{ $message }}</p> @enderror
    </div>

    <div>
    <label>Description</label>
    <textarea name="description" class="input">{{ old('description', $course->description ?? '') }}</textarea>
    @error('description') <p class="text-red-500">{{ $message }}</p> @enderror
    </div>

    @can('create', App\Models\Course::class)
    <div>
        <label>Instructor</label>
        <select name="instructor_id" class="input">
        <option value="">Select instructor</option>
        @foreach($instructors as $i)
            <option value="{{ $i->id }}" {{ (old('instructor_id', $course->instructor_id ?? '') == $i->id) ? 'selected' : '' }}>
            {{ $i->name }}
            </option>
        @endforeach
        </select>
    </div>
@endcan

<button class="btn mt-3">{{ $buttonText ?? 'Save' }}</button>
