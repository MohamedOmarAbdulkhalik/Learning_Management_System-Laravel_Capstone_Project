<header class="bg-white dark:bg-gray-800 shadow">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
        {{-- Logo --}}
        <a href="{{ route('courses.index') }}" 
           class="font-bold text-2xl bg-gradient-to-r from-green-500 to-blue-600 bg-clip-text text-transparent">
            LMS
        </a>

        {{-- Hamburger button for mobile --}}
        <button id="mobile-menu-btn" class="md:hidden px-3 py-2 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        {{-- Navigation --}}
        <nav id="navbar" class="hidden md:flex flex-col md:flex-row items-start md:items-center md:space-x-4 w-full md:w-auto mt-2 md:mt-0 bg-white dark:bg-gray-800 md:bg-transparent p-4 md:p-0 rounded-lg md:rounded-none shadow md:shadow-none">
            @auth
                <div class="flex flex-col md:flex-row md:items-center w-full md:w-auto space-y-2 md:space-y-0 md:space-x-4">
                    {{-- Notifications --}}
                    <div class="relative inline-block w-full md:w-auto">
                        <button id="notifications-btn" class="w-full md:w-auto px-3 py-2 flex justify-between items-center text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            Notifications
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="ml-2 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>

                        <div id="notifications-dropdown" class="absolute right-0 mt-2 w-full md:w-80 bg-white dark:bg-gray-700 border dark:border-gray-600 rounded shadow-lg hidden z-50">
                            <div class="p-3 bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-600">
                                <a href="{{ route('notifications.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 block text-center">
                                    View all notifications
                                </a>
                            </div>

                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <div class="max-h-60 overflow-y-auto">
                                    @foreach(auth()->user()->unreadNotifications->take(5) as $note)
                                        @php $data = $note->data; @endphp
                                        <div class="p-3 border-b dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 rounded-md">
                                            <a href="{{ $data['url'] ?? '#' }}" class="block text-sm font-medium text-gray-800 dark:text-gray-100 truncate">
                                                {{ $data['title'] ?? 'Notification' }}
                                            </a>
                                            <div class="text-xs text-gray-600 dark:text-gray-300 truncate">{{ \Illuminate\Support\Str::limit($data['message'] ?? '', 60) }}</div>
                                            <form method="POST" action="{{ route('notifications.read', $note->id) }}" class="mt-1">
                                                @csrf
                                                <button class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">Mark as read</button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="p-2 text-center border-t dark:border-gray-600 bg-gray-50 dark:bg-gray-800">
                                    <form method="POST" action="{{ route('notifications.readAll') }}">
                                        @csrf
                                        <button class="text-sm text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">Mark all as read</button>
                                    </form>
                                </div>
                            @else
                                <div class="p-4 text-center text-gray-500 dark:text-gray-300">No new notifications</div>
                            @endif
                        </div>
                    </div>

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

                    {{-- Dark/Light Mode Toggle --}}
                    <button id="theme-toggle" 
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        Toggle Theme
                    </button>
                </div>
            @else
                <div class="flex flex-col md:flex-row md:items-center w-full md:w-auto space-y-2 md:space-y-0 md:space-x-4">
                    <x-button-link href="{{ route('login') }}" variant="primary">
                        Login
                    </x-button-link>

                    <button id="theme-toggle" 
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        Toggle Theme
                    </button>
                </div>
            @endauth
        </nav>
    </div>
</header>

{{-- Script --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    const html = document.documentElement;

    // وضع افتراضي حسب LocalStorage
    if(localStorage.getItem('theme') === 'dark') {
        html.classList.add('dark');
    } else {
        html.classList.remove('dark');
    }

    // عند الضغط على الزر
    themeToggle.addEventListener('click', function() {
        html.classList.toggle('dark');

        if(html.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    });
});


//     document.addEventListener('DOMContentLoaded', () => {
//     const mobileMenuBtn = document.getElementById('mobile-menu-btn');
//     const navbar = document.getElementById('navbar');

//     mobileMenuBtn?.addEventListener('click', () => {
//         navbar.classList.toggle('hidden');
//     });
// });
</script>
@endpush