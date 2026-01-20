@extends('layouts.app')

@section('content')

<div class="relative w-full h-[400px] md:h-[480px] bg-gradient-to-br from-[#FFF0E5] via-[#FFE4D6] to-[#FFD1B8] rounded-[40px] p-8 md:p-12 overflow-hidden shadow-sm border border-white/50 flex flex-col items-center justify-center text-center">
    
    <div class="absolute top-[-20%] right-[-10%] w-96 h-96 bg-white/40 rounded-full blur-[80px]"></div>
    <div class="absolute bottom-[-20%] left-[-10%] w-72 h-72 bg-[#FF9357]/20 rounded-full blur-[60px]"></div>

    <div class="relative z-10 max-w-3xl mx-auto animate-fade-in-up">
        <span class="px-4 py-2 rounded-full bg-white/60 backdrop-blur-md border border-white text-[#FF9357] text-xs font-bold uppercase tracking-wider mb-4 inline-block shadow-sm">
            👋 Selamat Datang, {{ Auth::user()->name }}
        </span>
        <h1 class="font-extrabold text-4xl md:text-6xl text-[#070725] mb-4 leading-tight">
            Temukan Kost Impian <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF9357] to-[#FF6B2B]">Senyaman Rumah Sendiri.</span>
        </h1>
        <p class="text-gray-600 text-lg mb-10 max-w-xl mx-auto">
            Jelajahi ribuan pilihan kost eksklusif dengan fasilitas lengkap dan harga transparan.
        </p>

        <div class="w-full max-w-2xl bg-white p-3 rounded-full shadow-[0px_20px_50px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center gap-4 transition-transform hover:scale-[1.02] duration-300">
            <div class="pl-5 text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" placeholder="Cari kost di Jakarta, Bandung, atau Surabaya..." class="w-full bg-transparent border-none outline-none text-base text-[#070725] placeholder:text-gray-400 focus:ring-0">
            <button class="bg-[#070725] text-white px-8 py-3.5 rounded-full font-bold text-sm hover:bg-[#FF9357] transition-all shadow-lg hover:shadow-orange-500/30">
                Cari Sekarang
            </button>
        </div>
    </div>
</div>

<section class="mt-20">
    <div class="flex items-center justify-between mb-8">
        <h2 class="font-bold text-2xl text-[#070725]">Kategori Pilihan</h2>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @foreach ($categories as $category)
        <a href="{{ route('category.show', $category->slug) }}" class="group">
            <div class="bg-white rounded-3xl p-6 border border-transparent shadow-[0_10px_30px_rgba(0,0,0,0.02)] hover:border-[#FF9357]/30 hover:shadow-[0_20px_40px_rgba(255,147,87,0.15)] transition-all duration-300 flex flex-col items-center text-center h-full">
                <div class="w-20 h-20 mb-4 rounded-full bg-[#FFF5EC] group-hover:bg-[#FF9357] transition-colors duration-300 flex items-center justify-center overflow-hidden p-4">
                    <img src="{{ asset('storage/' . $category->image) }}" 
                         class="w-full h-full object-contain filter group-hover:brightness-0 group-hover:invert transition-all duration-300">
                </div>
                <span class="font-bold text-[#070725] group-hover:text-[#FF9357] transition-colors">
                    {{ $category->name }}
                </span>
            </div>
        </a>
        @endforeach
    </div>
</section>

<section class="mt-20">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-bold text-2xl text-[#070725]">Sedang Populer 🔥</h2>
            <p class="text-gray-400 text-sm mt-1">Kost yang paling banyak dicari minggu ini.</p>
        </div>
        <a href="#" class="px-5 py-2 rounded-full border border-gray-200 text-sm font-bold text-[#070725] hover:bg-[#070725] hover:text-white transition-all">Lihat Semua</a>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-8">
        @foreach ($popularBoardingHouses as $boardingHouse)
        <a href="{{ route('kos.show', $boardingHouse->slug) }}" class="group block h-full">
            <div class="bg-white rounded-[30px] p-3 border border-gray-100/50 shadow-[0_10px_30px_rgba(0,0,0,0.02)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] transition-all duration-300 h-full flex flex-col">
                <div class="relative w-full aspect-[4/3] rounded-[24px] overflow-hidden">
                    <img src="{{ asset('storage/' . $boardingHouse->thumbnail) }}" 
                         onerror="this.src='https://images.unsplash.com/photo-1522771753035-48482dd5f3af?q=80&w=600&auto=format&fit=crop'"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full shadow-sm">
                        <span class="text-[10px] font-bold tracking-wide uppercase text-[#FF9357]">{{ $boardingHouse->category->name }}</span>
                    </div>
                </div>

                <div class="mt-5 px-2 flex flex-col flex-grow">
                    <div class="flex items-center gap-1 mb-2 text-gray-400 text-xs font-medium">
                        <svg class="w-4 h-4 text-[#FF9357]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                        <p>{{ $boardingHouse->city->name }}</p>
                    </div>

                    <h3 class="font-bold text-lg text-[#070725] line-clamp-2 leading-snug group-hover:text-[#FF9357] transition-colors mb-2">
                        {{ $boardingHouse->name }}
                    </h3>
                    
                    <div class="mt-auto pt-4 flex items-end justify-between border-t border-dashed border-gray-100">
                        <div>
                            <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider mb-0.5">Mulai</p>
                            <div class="flex items-baseline gap-1">
                                <p class="text-[#FF9357] font-extrabold text-xl">
                                    Rp {{ number_format($boardingHouse->price, 0, ',', '.') }}
                                </p>
                                <span class="text-xs text-gray-400">/bln</span>
                            </div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-[#070725] group-hover:text-white transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>

<section class="mt-20 mb-24">
    <h2 class="font-bold text-2xl text-[#070725] mb-8">Jelajah Kota Favorit ✈️</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($cities as $city)
        <a href="{{ route('city.show', $city->slug) }}" class="group relative block h-[280px] rounded-[30px] overflow-hidden cursor-pointer">
            <img src="{{ asset('storage/' . $city->image) }}" 
                 onerror="this.src='https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?q=80&w=600&auto=format&fit=crop'"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            
            <div class="absolute inset-0 bg-gradient-to-t from-[#070725]/90 via-[#070725]/20 to-transparent"></div>
            
            <div class="absolute bottom-6 left-6 text-white transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                <h3 class="font-bold text-2xl mb-1">{{ $city->name }}</h3>
                <div class="flex items-center gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                    <span class="px-2 py-0.5 rounded bg-white/20 backdrop-blur-md text-xs font-bold border border-white/20">
                        {{ $city->boardingHouses->count() }} Kost
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>

@endsection