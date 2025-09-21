@extends('layouts.app')

@section('content')

<div class="flex flex-col md:flex-row items-center justify-between mt-16 md:mt-24 animate-fadeIn">
    {{-- نصوص وأزرار --}}
    <div class="md:w-1/2 space-y-6 px-4 md:px-0">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-gray-100 leading-tight animate-slideInLeft">
            Welcome to <span class="text-blue-600 dark:text-blue-400">LMS</span>
        </h1>
        <p class="text-gray-600 dark:text-gray-300 text-lg md:text-xl animate-slideInLeft delay-200">
            Learn, manage, and track courses and assignments in a modern, intuitive way.
        </p>

        <div class="flex flex-wrap gap-4 mt-6 animate-slideInUp delay-400">
            <!-- الأزرار مع hover scale -->
            <x-button-link href="{{ route('courses.index') }}" variant="outline" >
               Browse Courses
            </x-button-link>

                <x-button-link href="{{ route('login') }}"
>                   Login / Register
                </x-button-link>
        </div>
    </div>

    {{-- صورة --}}
    {{-- <div class="md:w-1/2 mt-10 md:mt-0 px-4 animate-slideInRight delay-600">
        <img src="{{ asset('images/welcome-illustration.svg') }}" alt="Learning Illustration" class="w-full h-auto">
    </div> --}}
</div>


{{-- Optional: Features Section --}}
<div class="mt-20 grid md:grid-cols-3 gap-8 px-4 md:px-0">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 text-center hover:shadow-lg transition">
        <div class="text-4xl mb-4 text-blue-600 dark:text-blue-400">🎓</div>
        <h3 class="font-semibold text-xl mb-2">Courses</h3>
        <p class="text-gray-600 dark:text-gray-300">Explore and enroll in the courses you love.</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 text-center hover:shadow-lg transition">
        <div class="text-4xl mb-4 text-green-600 dark:text-green-400">📝</div>
        <h3 class="font-semibold text-xl mb-2">Assignments</h3>
        <p class="text-gray-600 dark:text-gray-300">Submit and track your assignments effortlessly.</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 text-center hover:shadow-lg transition">
        <div class="text-4xl mb-4 text-purple-600 dark:text-purple-400">📊</div>
        <h3 class="font-semibold text-xl mb-2">Analytics</h3>
        <p class="text-gray-600 dark:text-gray-300">Monitor progress and performance easily.</p>
    </div>
</div>
@endsection
<style>
    .transition {
    transition: all 0.3s ease-in-out;
}

.hover\:scale-105:hover {
    transform: scale(1.05);
}
.hover\:shadow-xl:hover {
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

</style>