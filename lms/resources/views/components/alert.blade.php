@props([
    'type' => 'info', // success, error, warning, info
])

@php
$base = "p-4 rounded-lg flex items-center space-x-3";
$types = [
    'success' => 'bg-green-100 text-green-800 border border-green-200 dark:bg-green-800 dark:text-green-100',
    'error' => 'bg-red-100 text-red-800 border border-red-200 dark:bg-red-800 dark:text-red-100',
    'warning' => 'bg-yellow-100 text-yellow-800 border border-yellow-200 dark:bg-yellow-800 dark:text-yellow-100',
    'info' => 'bg-blue-100 text-blue-800 border border-blue-200 dark:bg-blue-800 dark:text-blue-100',
];
@endphp

<div {{ $attributes->merge(['class' => "$base {$types[$type]}"]) }}>
    {{ $slot }}
</div>
