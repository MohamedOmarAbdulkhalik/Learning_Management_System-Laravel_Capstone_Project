@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, danger, outline
    'full' => false,        // خيار إذا كنت تبي الزر ياخذ العرض كامل
])

@php
$base = "btn-transition font-semibold py-2.5 px-4 rounded-xl shadow-md 
         focus:outline-none focus:ring-2 focus:ring-offset-2 
         transition ease-in-out duration-200";

// الأنماط
$variants = [
    'primary'   => 'text-white bg-gradient-to-r from-green-600 to-blue-500 hover:from-green-700 hover:to-blue-600 focus:ring-green-400',
    'secondary' => 'bg-gray-200 text-gray-800 hover:bg-gray-300 focus:ring-gray-400 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600',
    'danger'    => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-400',
    'outline'   => 'border border-gray-300 text-gray-800 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700',
    'success'   => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-400',
];

// خيار العرض الكامل
$width = $full ? 'w-full' : '';
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "$base {$variants[$variant]} $width"]) }}>
    {{ $slot }}
</button>
