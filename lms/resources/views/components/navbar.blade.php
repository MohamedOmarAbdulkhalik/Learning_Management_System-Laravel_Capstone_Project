<header class="bg-white dark:bg-gray-800 shadow">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
        <a href="{{ route('courses.index') }}" class="font-bold text-xl text-blue-600 dark:text-blue-400">LMS</a>

        <nav class="flex items-center space-x-4">

            @auth
                <x-notifications />

                @if(auth()->user()->role === 'admin')
                    @include('layouts.partials.nav-admin')
                @elseif(auth()->user()->role === 'instructor')
                    @include('layouts.partials.nav-instructor')
                @else
                    @include('layouts.partials.nav-student')
                @endif

                <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                   class="text-gray-700 dark:text-gray-200 hover:text-blue-600">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-200 hover:text-blue-600">Login</a>
            @endauth

            {{-- Dark/Light Mode Toggle --}}
            <div class="ml-4">
                <button id="theme-toggle" 
                        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    Toggle Theme
                </button>
            </div>
        </nav>
    </div>
</header>
