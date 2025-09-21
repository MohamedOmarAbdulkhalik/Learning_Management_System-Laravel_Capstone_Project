@props([
    'title' => null,
    'footer' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 transition hover:shadow-lg']) }}>
    @if($title)
        <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-100">{{ $title }}</h2>
    @endif

    <div class="text-gray-700 dark:text-gray-300">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="mt-4 border-t pt-3 text-sm text-gray-600 dark:text-gray-400">
            {{ $footer }}
        </div>
    @endif
</div>
