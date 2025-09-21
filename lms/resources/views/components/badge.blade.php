@props([
    'type' => 'default', // success, error, warning, info, default
])

@php
$styles = [
    'success' => 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100',
    'error' => 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100',
    'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100',
    'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100',
    'default' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-100',
];
@endphp

<span {{ $attributes->merge(['class' => "px-2 py-1 text-xs font-semibold rounded-full {$styles[$type]}"]) }}>
    {{ $slot }}
</span>
