<!doctype html>
<html lang="en" >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'LMS')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100">
    
    {{-- Navbar --}}
    <x-navbar />

    {{-- Main Content --}}
    <main class="container mx-auto px-4 py-6">
        @yield('content')
    </main>

    {{-- Footer --}}
    <x-footer />

    @stack('scripts')
</body>
</html>



<script>
// document.addEventListener('DOMContentLoaded', function() {
//     const themeToggle = document.getElementById('theme-toggle');
//     const html = document.documentElement;

//     // وضع افتراضي حسب LocalStorage
//     if(localStorage.getItem('theme') === 'dark') {
//         html.classList.add('dark');
//     } else {
//         html.classList.remove('dark');
//     }

//     // عند الضغط على الزر
//     themeToggle.addEventListener('click', function() {
//         html.classList.toggle('dark');

//         if(html.classList.contains('dark')) {
//             localStorage.setItem('theme', 'dark');
//         } else {
//             localStorage.setItem('theme', 'light');
//         }
//     });
// });


    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('notifications-btn');
        const dropdown = document.getElementById('notifications-dropdown');

        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target) && e.target !== btn) {
                dropdown.classList.add('hidden');
            }
        });

        dropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });




    document.addEventListener('DOMContentLoaded', () => {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const navbar = document.getElementById('navbar');

    mobileMenuBtn?.addEventListener('click', () => {
        navbar.classList.toggle('hidden');
    });
});

</script>
