<!doctype html>
    <html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'LMS')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    <body class="bg-gray-100">
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
        <a href="{{ route('courses.index') }}" class="font-bold text-xl">LMS</a>

        <nav class="space-x-4">
            @auth
            @if(auth()->user()->role === 'admin')
                @include('layouts.partials.nav-admin')
            @elseif(auth()->user()->role === 'instructor')
                @include('layouts.partials.nav-instructor')
            @else
                @include('layouts.partials.nav-student')
            @endif

            <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            @else
            <a href="{{ route('login') }}">Login</a>
            @endauth
        </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-6">
        {{-- @include('layouts.partials.flash') flash messages partial --}}
        @yield('content')
    </main>
    </body>
    </html>
