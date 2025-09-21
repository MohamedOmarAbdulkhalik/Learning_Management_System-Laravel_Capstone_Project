@extends('layouts.guest')

@section('title', 'Login - LMS')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow-2xl rounded-3xl p-8 transform transition-all duration-300 hover:shadow-xl">
    
    <!-- الشعار والعنوان -->
    <div class="text-center mb-8">
        <div class="w-20 h-20 mx-auto flex items-center justify-center rounded-full bg-gradient-to-r from-green-500 to-blue-600 text-white text-3xl font-bold shadow-lg animate-float">
            {{ strtoupper(substr(config('app.name'),0,1)) }}
        </div>
        <h2 class="mt-4 text-3xl font-extrabold text-gray-900 dark:text-gray-100">
            Welcome Back!
        </h2>
        <p class="mt-2 text-gray-500 dark:text-gray-400">
            Please sign in to continue
        </p>
    </div>

    <!-- نموذج تسجيل الدخول -->
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Email Address
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                   class="input-transition w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                          bg-white dark:bg-gray-700
                          text-gray-900 dark:text-gray-100 
                          placeholder-gray-500 dark:placeholder-gray-400
                          focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Password
            </label>
            <input id="password" type="password" name="password" required 
                   class="input-transition w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                          bg-white dark:bg-gray-700
                          text-gray-900 dark:text-gray-100 
                          placeholder-gray-500 dark:placeholder-gray-400
                          focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember" 
                       class="h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500">
                <label for="remember_me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                    Remember me
                </label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" 
                   class="text-sm text-blue-600 dark:text-blue-400 hover:underline transition duration-200">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <x-button type="submit" 
                class="btn-transition w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 
                       text-white font-semibold py-3 px-4 rounded-xl shadow-md">
            Sign In
        </x-button>
    </form>

    <!-- Divider -->
    <div class="flex items-center my-6">
        <hr class="flex-grow border-gray-300 dark:border-gray-600">
        <span class="px-3 text-gray-500 dark:text-gray-400 text-sm">or</span>
        <hr class="flex-grow border-gray-300 dark:border-gray-600">
    </div>

    <!-- Register Link -->
    <div class="text-center">
        <p class="text-sm text-gray-600 dark:text-gray-300">
            Don't have an account? 
            <a href="{{ route('register') }}" 
               class="font-semibold text-blue-600 dark:text-blue-400 hover:underline transition duration-200">
                Sign up now
            </a>
        </p>
    </div>

    <!-- Theme Toggle -->
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