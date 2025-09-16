@csrf
<div>
    <label class="block">Title</label>
    <input type="text" name="title" value="{{ old('title', $lesson->title ?? '') }}" class="input" required>
    @error('title') <p class="text-red-500">{{ $message }}</p> @enderror
</div>

<div class="mt-3">
    <label class="block">Content</label>
    <textarea name="content" class="input" rows="5">{{ old('content', $lesson->content ?? '') }}</textarea>
    @error('content') <p class="text-red-500">{{ $message }}</p> @enderror
</div>

<div class="mt-3">
    <label class="block">Resource (PDF, Doc, Video)</label>
    <input type="file" name="resource" class="input-file">
    @if(!empty($lesson->resource_path))
        <p class="text-sm mt-2">Current: <a href="{{ Storage::url($lesson->resource_path) }}" target="_blank" class="underline">Open resource</a></p>
    @endif
    @error('resource') <p class="text-red-500">{{ $message }}</p> @enderror
</div>

<button class="btn mt-3">{{ $buttonText ?? 'Save' }}</button>
