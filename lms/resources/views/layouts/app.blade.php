<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'LMS')</title>
    @vite(['resources/css/app.css'])
    @stack('styles')
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('courses.index') }}" class="font-bold text-xl">LMS</a>

            <nav class="space-x-4">
                @auth
<div class="relative inline-block">
    {{-- زر الإشعارات --}}
    <button id="notifications-btn" class="px-3 py-2 relative">
        Notifications 
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </button>

    {{-- قائمة الإشعارات (مخفية في البداية) --}}
    <div id="notifications-dropdown" class="absolute right-0 mt-2 w-80 bg-white border rounded shadow hidden z-50">
        {{-- رابط عرض جميع الإشعارات --}}
        <div class="p-3 bg-gray-50 border-b">
            <a href="{{ route('notifications.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 block text-center">
                View all notifications
            </a>
        </div>

        @if(auth()->user()->unreadNotifications->count() > 0)
            {{-- عناوين الإشعارات غير المقروءة --}}
            <div class="max-h-60 overflow-y-auto">
                @foreach(auth()->user()->unreadNotifications->take(5) as $note)
                    @php $data = $note->data; @endphp
                    <div class="p-3 border-b hover:bg-gray-50">
                        <a href="{{ $data['url'] ?? '#' }}" class="block text-sm font-medium">
                            {{ $data['title'] ?? 'Notification' }}
                        </a>
                        <div class="text-xs text-gray-600">{{ \Illuminate\Support\Str::limit($data['message'] ?? '', 60) }}</div>
                        <form method="POST" action="{{ route('notifications.read', $note->id) }}" class="mt-1">
                            @csrf
                            <button class="text-xs text-blue-600 hover:text-blue-800">Mark as read</button>
                        </form>
                    </div>
                @endforeach
            </div>

            {{-- زر标记 الكل كمقروء --}}
            <div class="p-2 text-center border-t bg-gray-50">
                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf
                    <button class="text-sm text-gray-700 hover:text-blue-600">Mark all as read</button>
                </form>
            </div>
        @else
            {{-- لا توجد إشعارات --}}
            <div class="p-4 text-center text-gray-500">
                No new notifications
            </div>
        @endif
    </div>
</div>
@endauth

                {{-- باقي المحتوى --}}
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
        @yield('content')
    </main>
    
    {{-- إضافة JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationsBtn = document.getElementById('notifications-btn');
            const notificationsDropdown = document.getElementById('notifications-dropdown');
            
            // عند النقر على زر الإشعارات
            notificationsBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                notificationsDropdown.classList.toggle('hidden');
            });
            
            // إغلاق القائمة عند النقر خارجها
            document.addEventListener('click', function(e) {
                if (!notificationsDropdown.contains(e.target) && e.target !== notificationsBtn) {
                    notificationsDropdown.classList.add('hidden');
                }
            });
            
            // منع إغلاق القائمة عند النقر داخلها
            notificationsDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
    
    @vite(['resources/js/app.js'])
    @stack('scripts')

</body>
</html>