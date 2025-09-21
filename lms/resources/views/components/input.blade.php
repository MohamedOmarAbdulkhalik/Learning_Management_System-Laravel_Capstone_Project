@props([
    'label' => null,
    'type' => 'text',
    'name',
    'value' => '',
])

<div class="mb-4">
    @if($label)
        <label class="block text-gray-700 dark:text-gray-200 mb-1 font-medium" for="{{ $name }}">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}"
           {{ $attributes->merge(['class' => 'w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-400 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100']) }}>
    @error($name)
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
