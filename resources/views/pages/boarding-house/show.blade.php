@extends('layouts.app')

@section('content')

{{-- 
    ===============================================================
    KONFIGURASI ICON & WARNA
    ===============================================================
--}}
@php
    function getStyle($name) {
        $name = strtolower($name);

        $facilityConfig = [
            // --- FASILITAS KAMAR ---
            'ac'        => ['img' => 'air-conditioner.png', 'bg' => 'bg-cyan-50'],
            'sejuk'     => ['img' => 'ac.png',      'bg' => 'bg-cyan-50'],
            'kasur'     => ['img' => 'double-bed.png',     'bg' => 'bg-orange-50'],
            'bantal'    => ['img' => 'pillow.png',     'bg' => 'bg-orange-50'],
            'lemari'    => ['img' => 'cupboard.png','bg' => 'bg-amber-50'],
            'meja'      => ['img' => 'table.png',    'bg' => 'bg-amber-50'],
            'kursi'     => ['img' => 'chair.png',   'bg' => 'bg-amber-50'],
            'cermin'    => ['img' => 'magic-mirror.png',  'bg' => 'bg-amber-50'], // <--- BARU: CERMIN
            'tv'        => ['img' => 'smart-tv.png',      'bg' => 'bg-indigo-50'],

            // --- FASILITAS KAMAR MANDI ---
            'mandi'     => ['img' => 'lavatory.png',    'bg' => 'bg-blue-50'],
            'shower'    => ['img' => 'shower.png',  'bg' => 'bg-blue-50'],
            'kloset'    => ['img' => 'toilet.png',  'bg' => 'bg-blue-50'],
            'wastafel'  => ['img' => 'washbasin.png',    'bg' => 'bg-blue-50'], // <--- BARU: WASTAFEL
            'water'     => ['img' => 'shower.png',  'bg' => 'bg-blue-50'],
            'air'       => ['img' => 'water-heater.png',  'bg' => 'bg-blue-50'],

            // --- FASILITAS UMUM ---
            'dapur'     => ['img' => 'cooking-tools.png', 'bg' => 'bg-rose-50'],
            'masak'     => ['img' => 'kitchen.png', 'bg' => 'bg-rose-50'],
            'kompor'    => ['img' => 'kitchen.png', 'bg' => 'bg-rose-50'],
            'kulkas'    => ['img' => 'fridge.png',  'bg' => 'bg-cyan-50'],
            'kamera'      => ['img' => 'cctv-camera.png',    'bg' => 'bg-slate-100'],
            'keamanan'  => ['img' => 'cctv.png',    'bg' => 'bg-slate-100'],
            'security'  => ['img' => 'cctv.png',    'bg' => 'bg-slate-100'],
            'wifi'      => ['img' => 'wifi-signal.png',    'bg' => 'bg-indigo-50'],
            'internet'  => ['img' => 'wifi.png',    'bg' => 'bg-indigo-50'],
            'laundry'   => ['img' => 'laundry-machine.png', 'bg' => 'bg-blue-50'],
            'jemuran'   => ['img' => 'laundry.png', 'bg' => 'bg-blue-50'],
            'tamu'      => ['img' => 'tourist.png', 'bg' => 'bg-emerald-50'],

            // --- FASILITAS PARKIR ---
            'motor'     => ['img' => 'motorcycle-parking.png',   'bg' => 'bg-gray-100'],
            'mobil'     => ['img' => 'parking-car.png',     'bg' => 'bg-gray-100'],
            'sepeda'    => ['img' => 'bike.png',    'bg' => 'bg-gray-100'],
            'garasi'    => ['img' => 'garage.png',  'bg' => 'bg-gray-100'],
            'carport'   => ['img' => 'garage.png',  'bg' => 'bg-gray-100'],

            // --- LAINNYA ---
            'listrik'   => ['img' => 'lightning.png', 'bg' => 'bg-yellow-50'],
            'dilarang'  => ['img' => 'forbidden.png',      'bg' => 'bg-red-50'],
            'rokok'     => ['img' => 'no-smoking.png', 'bg' => 'bg-red-50'],
        ];

        foreach ($facilityConfig as $keyword => $style) {
            if (str_contains($name, $keyword)) {
                return $style;
            }
        }
        return ['img' => 'check.png', 'bg' => 'bg-green-50'];
    }
@endphp

<nav class="flex items-center gap-2 text-sm text-gray-500 mb-6 animate-fade-in-down">
    <a href="{{ route('dashboard') }}" class="hover:text-[#070725] transition-colors">Beranda</a>
    <span>/</span>
    <a href="{{ route('city.show', $boardingHouse->city->slug) }}" class="hover:text-[#070725] transition-colors">{{ $boardingHouse->city->name }}</a>
    <span>/</span>
    <span class="text-[#070725] font-semibold">{{ $boardingHouse->name }}</span>
</nav>

<section class="relative mb-8 rounded-[30px] overflow-hidden shadow-sm animate-fade-in">
    <div class="relative w-full h-[400px] md:h-[500px]">
        <img src="{{ asset('storage/' . $boardingHouse->thumbnail) }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        <div class="absolute top-6 right-6 z-20">
            <form action="{{ route('boarding-house.toggle-wishlist', $boardingHouse->slug) }}" method="POST">
                @csrf
                <button type="submit" class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 {{ \App\Models\Wishlist::where('user_id', Auth::id())->where('boarding_house_id', $boardingHouse->id)->exists() ? 'bg-[#FF9357] text-white shadow-lg shadow-orange-500/40' : 'bg-white/30 backdrop-blur-md text-white hover:bg-white hover:text-red-500' }}">
                    <svg class="w-6 h-6 {{ \App\Models\Wishlist::where('user_id', Auth::id())->where('boarding_house_id', $boardingHouse->id)->exists() ? 'fill-current' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</section>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-10 pb-20">
    <div class="lg:col-span-2 flex flex-col gap-8">
        
        <div class="bg-white p-6 rounded-[24px] border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="px-3 py-1 bg-orange-50 text-[#FF9357] text-xs font-bold rounded-full uppercase tracking-wide">
                    {{ $boardingHouse->category->name }}
                </span>
                <div class="flex items-center gap-1 text-yellow-400">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <span class="text-sm font-bold text-[#070725] ml-1">4.8</span>
                    <span class="text-xs text-gray-400 font-normal">(120 Review)</span>
                </div>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-[#070725] leading-tight mb-2">{{ $boardingHouse->name }}</h1>
            <div class="flex flex-col md:flex-row md:items-center gap-4 text-sm text-gray-500 mt-2">
                <div class="flex items-center gap-2">
                     <svg class="w-5 h-5 text-[#FF9357]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <p>{{ $boardingHouse->city->name }}</p>
                </div>
                <div class="hidden md:block w-1 h-1 rounded-full bg-gray-300"></div>
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                        @if($boardingHouse->user->avatar ?? false)
                            <img src="{{ asset('storage/' . $boardingHouse->user->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-xs font-bold text-gray-500">{{ substr($boardingHouse->user->name ?? 'O', 0, 1) }}</span>
                        @endif
                    </div>
                    <p>Dikelola oleh <span class="font-bold text-[#070725]">{{ $boardingHouse->user->name ?? 'Owner' }}</span></p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[24px] border border-gray-100 shadow-sm">
            <h2 class="font-bold text-lg text-[#070725] mb-4">Spesifikasi Tipe Kamar</h2>
            <div class="flex items-center gap-4 text-sm text-gray-600">
                <div class="flex items-center gap-2 px-4 py-2 bg-gray-50 rounded-lg">
                    <svg class="w-5 h-5 text-[#FF9357]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span class="font-semibold">{{ $boardingHouse->room_size }} meter</span>
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-gray-50 rounded-lg">
                    <svg class="w-5 h-5 text-[#FF9357]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <span class="font-semibold">Termasuk Listrik</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[24px] border border-gray-100 shadow-sm">
            <h2 class="font-bold text-lg text-[#070725] mb-4">Fasilitas Kamar</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @php
                    $roomFacilities = $boardingHouse->room_facilities;
                    if (is_string($roomFacilities)) {
                        $decoded = json_decode($roomFacilities, true);
                        $roomFacilities = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : explode(',', $roomFacilities);
                    }
                    $roomFacilities = is_array($roomFacilities) ? $roomFacilities : [];
                @endphp
                @foreach ($roomFacilities as $facility)
                    @if(trim($facility) != '')
                    @php $style = getStyle(trim($facility)); @endphp
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white border border-gray-100 hover:border-gray-200 transition-colors shadow-sm">
                        <div class="w-10 h-10 flex shrink-0 items-center justify-center rounded-full {{ $style['bg'] }}">
                            <img src="{{ asset('icons/' . $style['img']) }}" alt="icon" class="w-6 h-6 object-contain">
                        </div>
                        <span class="text-sm font-bold text-gray-700">{{ trim($facility) }}</span>
                    </div>
                    @endif
                @endforeach
                @if(count($roomFacilities) < 1) <p class="text-sm text-gray-400 italic">Tidak ada data fasilitas.</p> @endif
            </div>
        </div>

        <div class="bg-white p-6 rounded-[24px] border border-gray-100 shadow-sm">
            <h2 class="font-bold text-lg text-[#070725] mb-4">Fasilitas Kamar Mandi</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @php
                    $bathroomFacilities = $boardingHouse->bathroom_facilities;
                    if (is_string($bathroomFacilities)) {
                        $decoded = json_decode($bathroomFacilities, true);
                        $bathroomFacilities = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : explode(',', $bathroomFacilities);
                    }
                    $bathroomFacilities = is_array($bathroomFacilities) ? $bathroomFacilities : [];
                @endphp
                @foreach ($bathroomFacilities as $facility)
                    @if(trim($facility) != '')
                    @php $style = getStyle(trim($facility)); @endphp
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white border border-gray-100 hover:border-gray-200 transition-colors shadow-sm">
                        <div class="w-10 h-10 flex shrink-0 items-center justify-center rounded-full {{ $style['bg'] }}">
                            <img src="{{ asset('icons/' . $style['img']) }}" alt="icon" class="w-6 h-6 object-contain">
                        </div>
                        <span class="text-sm font-bold text-gray-700">{{ trim($facility) }}</span>
                    </div>
                    @endif
                @endforeach
                @if(count($bathroomFacilities) < 1) <p class="text-sm text-gray-400 italic">Tidak ada fasilitas kamar mandi.</p> @endif
            </div>
        </div>

        <div class="bg-white p-6 rounded-[24px] border border-gray-100 shadow-sm">
            <h2 class="font-bold text-lg text-[#070725] mb-4">Fasilitas Umum</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @php
                    $generalFacilities = $boardingHouse->general_facilities;
                    if (is_string($generalFacilities)) {
                        $decoded = json_decode($generalFacilities, true);
                        $generalFacilities = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : explode(',', $generalFacilities);
                    }
                    $generalFacilities = is_array($generalFacilities) ? $generalFacilities : [];
                @endphp
                @foreach ($generalFacilities as $facility)
                    @if(trim($facility) != '')
                    @php $style = getStyle(trim($facility)); @endphp
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white border border-gray-100 hover:border-gray-200 transition-colors shadow-sm">
                        <div class="w-10 h-10 flex shrink-0 items-center justify-center rounded-full {{ $style['bg'] }}">
                            <img src="{{ asset('icons/' . $style['img']) }}" alt="icon" class="w-6 h-6 object-contain">
                        </div>
                        <span class="text-sm font-bold text-gray-700">{{ trim($facility) }}</span>
                    </div>
                    @endif
                @endforeach
                @if(count($generalFacilities) < 1) <p class="text-sm text-gray-400 italic">Tidak ada fasilitas umum.</p> @endif
            </div>
        </div>

        <div class="bg-white p-6 rounded-[24px] border border-gray-100 shadow-sm">
            <h2 class="font-bold text-lg text-[#070725] mb-4">Fasilitas Parkir</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @php
                    $parkingFacilities = $boardingHouse->parking_facilities;
                    if (is_string($parkingFacilities)) {
                        $decoded = json_decode($parkingFacilities, true);
                        $parkingFacilities = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : explode(',', $parkingFacilities);
                    }
                    $parkingFacilities = is_array($parkingFacilities) ? $parkingFacilities : [];
                @endphp
                @foreach ($parkingFacilities as $facility)
                    @if(trim($facility) != '')
                    @php $style = getStyle(trim($facility)); @endphp
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white border border-gray-100 hover:border-gray-200 transition-colors shadow-sm">
                        <div class="w-10 h-10 flex shrink-0 items-center justify-center rounded-full {{ $style['bg'] }}">
                            <img src="{{ asset('icons/' . $style['img']) }}" alt="icon" class="w-6 h-6 object-contain">
                        </div>
                        <span class="text-sm font-bold text-gray-700">{{ trim($facility) }}</span>
                    </div>
                    @endif
                @endforeach
                @if(count($parkingFacilities) < 1) <p class="text-sm text-gray-400 italic">Tidak ada fasilitas parkir.</p> @endif
            </div>
        </div>

        <div class="bg-white p-6 rounded-[24px] border border-gray-100 shadow-sm">
            <h2 class="font-bold text-lg text-[#070725] mb-4">Peraturan Khusus</h2>
            <ul class="flex flex-col gap-3">
                @php
                    $rules = $boardingHouse->rules;
                    if (is_string($rules)) {
                        $decoded = json_decode($rules, true);
                        $rules = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : explode(',', $rules);
                    }
                    $rules = is_array($rules) ? $rules : [];
                @endphp
                @foreach ($rules as $rule)
                    @if(trim($rule) != '')
                    @php 
                        $isNegative = str_contains(strtolower($rule), 'dilarang') || str_contains(strtolower($rule), 'tidak boleh');
                    @endphp
                    <li class="flex items-center gap-3 text-gray-600 text-sm font-medium">
                        @if($isNegative)
                            <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </div>
                        @else
                            <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        @endif
                        {{ trim($rule) }}
                    </li>
                    @endif
                @endforeach
                @if(count($rules) < 1) <li class="text-sm text-gray-400 italic">Tidak ada peraturan khusus.</li> @endif
            </ul>
        </div>

        <div class="bg-white p-6 rounded-[24px] border border-gray-100 shadow-sm">
            <h2 class="font-bold text-lg text-[#070725] mb-4">Tentang Kost</h2>
            <div class="text-gray-500 leading-relaxed text-sm md:text-base prose prose-orange max-w-none">
                {!! $boardingHouse->description !!}
            </div>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="sticky top-28 bg-white p-6 rounded-[24px] border border-gray-100 shadow-[0_10px_40px_rgba(0,0,0,0.05)]">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-sm text-gray-400 font-medium">Mulai dari</p>
                    <div class="flex items-end gap-1">
                        <h3 class="text-2xl font-bold text-[#FF9357]">
                            Rp {{ number_format($boardingHouse->price, 0, ',', '.') }}
                        </h3>
                        <span class="text-sm text-gray-400 mb-1">/bulan</span>
                    </div>
                </div>
                <div class="px-3 py-1 rounded-lg bg-red-50 text-red-500 text-xs font-bold border border-red-100">PROMO</div>
            </div>
            <hr class="border-dashed border-gray-100 mb-6">
            <form action="{{ route('booking.check', $boardingHouse->slug) }}" class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-[#070725]">Tanggal Mulai Ngekos</label>
                    <div class="relative">
                        <input type="date" name="start_date" class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#FF9357] focus:border-[#FF9357] text-sm font-semibold" required>
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-[#070725]">Durasi Sewa</label>
                    <select name="duration" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#FF9357] focus:border-[#FF9357] text-sm font-semibold">
                        <option value="1">1 Bulan</option>
                        <option value="3">3 Bulan (Diskon 5%)</option>
                        <option value="6">6 Bulan (Diskon 10%)</option>
                        <option value="12">1 Tahun (Diskon 15%)</option>
                    </select>
                </div>
                <button type="submit" class="mt-4 w-full py-4 bg-[#070725] hover:bg-[#FF9357] text-white font-bold rounded-full transition-all duration-300 shadow-lg shadow-[#070725]/20 hover:shadow-orange-500/30">
                    Booking Sekarang
                </button>
            </form>
            <p class="text-center text-xs text-gray-400 mt-4">Tidak dikenakan biaya saat ini.</p>
        </div>
    </div>
</div>
@endsection