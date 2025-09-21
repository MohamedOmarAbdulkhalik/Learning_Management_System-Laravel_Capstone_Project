<header class="bg-white dark:bg-gray-800 shadow">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
        {{-- Logo --}}
        <a href="{{ route('courses.index') }}" 
           class="font-bold text-2xl bg-gradient-to-r from-green-500 to-blue-600 bg-clip-text text-transparent">
            LMS
        </a>

        {{-- Navigation --}}
        <nav class="flex items-center space-x-4">
            @auth
                {{-- Notifications --}}
                <x-notifications />

                {{-- Role-based Links --}}
                @if(auth()->user()->role === 'admin')
                    @include('layouts.partials.nav-admin')
                @elseif(auth()->user()->role === 'instructor')
                    @include('layouts.partials.nav-instructor')
                @else
                    @include('layouts.partials.nav-student')
                @endif

                {{-- Logout --}}
                <x-button-link href="{{ route('logout') }}" 
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();" 
                               variant="outline">
                    Logout
                </x-button-link>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            @else
                <x-button-link href="{{ route('login') }}" variant="primary">
                    Login
                </x-button-link>
            @endauth

            {{-- Dark/Light Mode Toggle --}}
                <button id="theme-toggle" 
                        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    Toggle Theme
                </button>
        </nav>
    </div>
</header>

