<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Cozyn Home') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900">
    
    <div class="min-h-screen flex items-center justify-center relative overflow-hidden bg-gray-900">
        
        <img src="https://images.unsplash.com/photo-1522771753035-48482dd5f3af?q=80&w=2670&auto=format&fit=crop" 
             class="absolute inset-0 w-full h-full object-cover opacity-40" 
             alt="Background">
             
        <div class="absolute inset-0 bg-gradient-to-br from-[#070725]/90 via-[#070725]/50 to-[#FF9357]/20"></div>

        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-[#FF9357] rounded-full blur-[150px] opacity-30 animate-pulse"></div>

        <div class="relative z-10 w-full px-4">
            {{ $slot }}
        </div>
        
    </div>
</body>
</html>