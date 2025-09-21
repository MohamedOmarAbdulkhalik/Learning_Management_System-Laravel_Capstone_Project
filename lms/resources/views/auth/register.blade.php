@extends('layouts.guest')

@section('title', 'Register - LMS')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow-2xl rounded-3xl p-8 transform transition-all duration-300 hover:shadow-xl">
    
    <!-- الشعار والعنوان -->
    <div class="text-center mb-8">
        <div class="w-20 h-20 mx-auto flex items-center justify-center rounded-full bg-gradient-to-r from-green-500 to-blue-600 text-white text-3xl font-bold shadow-lg animate-float">
            {{ strtoupper(substr(config('app.name'),0,1)) }}
        </div>
        <h2 class="mt-4 text-3xl font-extrabold text-gray-900 dark:text-gray-100">
            Create an Account
        </h2>
        <p class="mt-2 text-gray-500 dark:text-gray-400">
            Join us and get started today
        </p>
    </div>

    <!-- نموذج التسجيل -->
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- الاسم -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="input-transition w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                          bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 
                          placeholder-gray-500 dark:placeholder-gray-400
                          focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            @error('name')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- البريد الإلكتروني -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                   class="input-transition w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                          bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 
                          placeholder-gray-500 dark:placeholder-gray-400
                          focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- كلمة المرور -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="input-transition w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                          bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 
                          placeholder-gray-500 dark:placeholder-gray-400
                          focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- تأكيد كلمة المرور -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="input-transition w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                          bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 
                          placeholder-gray-500 dark:placeholder-gray-400
                          focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- زر التسجيل -->
        <button type="submit" 
                class="btn-transition w-full bg-gradient-to-r from-green-600 to-blue-500 hover:from-green-700 hover:to-blue-600 
                       text-white font-semibold py-3 px-4 rounded-xl shadow-md">
            Create Account
        </button>
    </form>

    <!-- فاصل -->
    <div class="flex items-center my-6">
        <hr class="flex-grow border-gray-300 dark:border-gray-600">
        <span class="px-3 text-gray-500 dark:text-gray-400 text-sm">or</span>
        <hr class="flex-grow border-gray-300 dark:border-gray-600">
    </div>

    <!-- رابط تسجيل الدخول -->
    <div class="text-center">
        <p class="text-sm text-gray-600 dark:text-gray-300">
            Already have an account?
            <a href="{{ route('login') }}" 
               class="font-semibold text-blue-600 dark:text-blue-400 hover:underline transition duration-200">
                Log in
            </a>
        </p>
    </div>

    <!-- زر تبديل الوضع الليلي -->
    <div class="mt-6 text-center">
        <button id="theme-toggle" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 
                                        transition duration-200 text-sm flex items-center justify-center mx-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
            Toggle Theme
        </button>
    </div>
</div>
@endsection