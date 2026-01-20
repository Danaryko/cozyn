<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cozyn Kost</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-b from-[#FAFAFA] to-[#FFF6F0] min-h-screen font-poppins text-[#070725] antialiased selection:bg-[#FF9357] selection:text-white">
    
    @include('includes.navigation')

    <main class="w-full max-w-screen-2xl mx-auto px-4 md:px-8 mt-8 min-h-screen pb-20">
        @yield('content')
    </main>

    <footer class="w-full text-center py-10 text-gray-400 text-sm mt-20 border-t border-gray-200/50">
        <p>&copy; {{ date('Y') }} Cozyn Kost. Comfort Living.</p>
    </footer>

    @stack('before-scripts')
    @stack('after-scripts')
</body>
</html>