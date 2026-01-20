@extends('layouts.app')

@section('content')
<div class="mb-8 animate-fade-in-down">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full border border-gray-100 shadow-sm hover:shadow-md transition-all text-sm font-bold text-[#070725]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali
    </a>
</div>

<div class="bg-[linear-gradient(180deg,#F2F9E6_0%,#D2EDE4_100%)] rounded-[30px] p-8 md:p-12 mb-8 relative overflow-hidden shadow-sm border border-[#E5E7EB] animate-fade-in">
    <div class="relative z-10">
        <h1 class="font-extrabold text-3xl md:text-4xl text-[#070725] mb-2">{{ $city->name }}</h1>
        <p class="text-gray-500 font-medium">Tersedia {{ $city->boardingHouses->count() }} Kos</p>
    </div>
    <div class="absolute top-0 right-0 h-full w-1/2 bg-gradient-to-l from-white/40 to-transparent"></div>
    <div class="absolute bottom-[-20px] right-[-20px] w-64 h-64 bg-[#FF9357]/10 rounded-full blur-3xl"></div>
    
    <div class="absolute top-1/2 right-8 md:right-12 -translate-y-1/2 w-24 h-24 md:w-32 md:h-32 bg-white/60 backdrop-blur-md rounded-full flex items-center justify-center shadow-lg border border-white">
        <div class="w-20 h-20 md:w-28 md:h-28 rounded-full overflow-hidden">
             <img src="{{ asset('storage/' . $city->image) }}" class="w-full h-full object-cover">
        </div>
    </div>
</div>

<div class="flex flex-col gap-6 pb-20">
    @forelse ($city->boardingHouses as $boardingHouse)
    <a href="{{ route('kos.show', $boardingHouse->slug) }}" class="group block animate-fade-in-up">
        <div class="bg-white rounded-[24px] p-4 border border-gray-100 shadow-sm hover:border-[#FF9357] hover:shadow-[0_10px_30px_rgba(255,147,87,0.15)] transition-all duration-300 flex flex-col md:flex-row gap-6">
            
            <div class="w-full md:w-[280px] h-[200px] rounded-[20px] overflow-hidden shrink-0 relative">
                <img src="{{ asset('storage/' . $boardingHouse->thumbnail) }}" 
                     onerror="this.src='https://images.unsplash.com/photo-1522771753035-48482dd5f3af?q=80&w=600&auto=format&fit=crop'"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                
                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full shadow-sm border border-white">
                    <span class="text-xs font-bold text-[#070725]">{{ $boardingHouse->category->name }}</span>
                </div>
            </div>

            <div class="flex flex-col justify-center flex-grow py-2">
                <h3 class="font-bold text-xl text-[#070725] mb-2 group-hover:text-[#FF9357] transition-colors">{{ $boardingHouse->name }}</h3>
                
                <div class="flex items-center gap-2 text-gray-400 text-sm mb-6">
                    <svg class="w-4 h-4 text-[#FF9357]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                    <span>{{ $city->name }}</span>
                </div>

                <div class="flex flex-wrap gap-3 mb-6">
                    @php
                        // LOGIKA PERBAIKAN: Cek apakah string, kalau iya decode dulu
                        $facilities = $boardingHouse->room_facilities;
                        if (is_string($facilities)) {
                            $facilities = json_decode($facilities, true);
                        }
                        // Pastikan jadi array (kalau gagal decode, jadi array kosong)
                        if (!is_array($facilities)) {
                            $facilities = [];
                        }
                    @endphp

                    @foreach (array_slice($facilities, 0, 3) as $facility)
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-50 rounded-lg border border-gray-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                            <span class="text-xs font-semibold text-gray-600">{{ $facility }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-auto flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-[#FF9357]">
                            Rp {{ number_format($boardingHouse->price, 0, ',', '.') }}
                            <span class="text-xs text-gray-400 font-normal">/bulan</span>
                        </p>
                    </div>
                    <div class="px-5 py-2.5 rounded-full bg-[#070725] text-white text-sm font-bold group-hover:bg-[#FF9357] transition-all">
                        Lihat Detail
                    </div>
                </div>
            </div>
        </div>
    </a>
    @empty
        <div class="text-center py-20">
            <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <p class="text-gray-500 font-medium">Belum ada data kos di kota ini.</p>
        </div>
    @endforelse
</div>
@endsection