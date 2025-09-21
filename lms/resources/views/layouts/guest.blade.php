<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'LMS')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .input-transition {
            transition: all 0.3s ease;
        }
        .input-transition:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-transition {
            transition: all 0.2s ease;
        }
        .btn-transition:hover {
            transform: translateY(-2px);
        }
        .btn-transition:active {
            transform: translateY(0);
        }
    </style>
    @stack('styles')
</head>
<body class="h-full bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-900 dark:to-gray-800 flex items-center justify-center p-4">
    
    {{-- المحتوى الرئيسي --}}
    <main class="w-full max-w-md">
        @yield('content')
    </main>

    {{-- سكريبت إدارة الوضع الليلي --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            const html = document.documentElement;

            // التحقق من الإعدادات المحفوظة
            const savedTheme = localStorage.getItem('theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
                html.classList.add('dark');
            }

            // إضافة مستمع الحدث لتبديل الوضع
            if (themeToggle) {
                themeToggle.addEventListener('click', function() {
                    html.classList.toggle('dark');
                    
                    if (html.classList.contains('dark')) {
                        localStorage.setItem('theme', 'dark');
                    } else {
                        localStorage.setItem('theme', 'light');
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>