@extends('layouts.app')

@section('content')
    <div class="px-5 mt-8 mb-4">
        <h1 class="font-bold text-2xl text-[#070725]">Kos Favorit ❤️</h1>
        <p class="text-gray-500 text-sm">Daftar kos yang kamu simpan.</p>
    </div>

    @if($boardingHouses->count() > 0)
        <div class="flex flex-col gap-4 px-5 pb-24">
            @foreach ($boardingHouses as $boardingHouse)
            <a href="{{ route('kos.show', $boardingHouse->slug) }}" class="card">
                <div class="flex bg-white p-4 rounded-[20px] border border-gray-100 shadow-sm hover:border-[#FF9357] transition-all">
                    <div class="w-[90px] h-[90px] rounded-2xl overflow-hidden shrink-0">
                         <img src="{{ asset('storage/' . $boardingHouse->thumbnail) }}" class="w-full h-full object-cover" alt="thumbnail">
                    </div>
                    <div class="ml-4 flex flex-col justify-center w-full">
                        <h3 class="font-bold text-base text-[#070725] line-clamp-1">{{ $boardingHouse->name }}</h3>
                        <div class="flex items-center gap-1 mt-1 text-gray-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <p class="text-xs">{{ $boardingHouse->city->name }}</p>
                        </div>
                        <p class="text-[#FF9357] font-bold text-base mt-2">
                            Rp {{ number_format($boardingHouse->price, 0, ',', '.') }}
                            <span class="text-xs text-gray-400 font-normal">/bln</span>
                        </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center mt-20 px-5 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </div>
            <h3 class="font-bold text-lg text-[#070725]">Belum ada favorit</h3>
            <p class="text-sm text-gray-500 mt-2">Kamu belum menandai kos apapun sebagai favorit.</p>
            <a href="{{ route('dashboard') }}" class="mt-6 px-6 py-3 bg-[#FF9357] text-white rounded-full font-bold text-sm">Cari Kos Sekarang</a>
        </div>
    @endif

    @include('includes.navigation')
@endsection