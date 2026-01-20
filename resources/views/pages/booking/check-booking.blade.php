@extends('layouts.app')

@section('content')
    <div class="relative min-h-screen bg-[#FAFAFA]">
        <div class="flex items-center justify-between px-5 pt-6 pb-4 bg-white shadow-sm">
            <a href="{{ route('kos.show', $boardingHouse->slug) }}" class="w-10 h-10 flex items-center justify-center bg-white border border-[#E5E5E5] rounded-full">
                <svg class="w-6 h-6 text-[#070725]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="font-bold text-lg text-[#070725]">Booking Information</h1>
            <div class="w-10"></div>
        </div>

        <div class="px-5 mt-6 pb-10">
            <div class="bg-white rounded-[30px] p-6 border border-[#F1F2F6]">
                
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-[80px] h-[80px] rounded-2xl overflow-hidden">
                        <img src="{{ asset('storage/' . $boardingHouse->thumbnail) }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-[#070725] line-clamp-1">{{ $boardingHouse->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $boardingHouse->city->name }}</p>
                    </div>
                </div>

                <hr class="border-[#F1F2F6] mb-6">

                <form action="{{ route('check-booking.show', $boardingHouse->slug) }}" method="POST" class="flex flex-col gap-5">
                    @csrf
                    
                    <div class="flex flex-col gap-2">
                        <label for="start_date" class="font-semibold text-sm text-[#070725]">Tanggal Mulai Ngekos</label>
                        <div class="relative">
                            <input type="date" name="start_date" id="start_date" required
                                   class="w-full rounded-full border border-[#F1F2F6] px-5 py-3 focus:outline-none focus:border-[#FF9357] transition-all text-[#070725] font-medium placeholder:text-gray-400">
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="duration" class="font-semibold text-sm text-[#070725]">Durasi Sewa (Bulan)</label>
                        <div class="relative">
                            <input type="number" name="duration" id="duration" min="1" max="12" value="1" required oninput="updateTotal()"
                                   class="w-full rounded-full border border-[#F1F2F6] px-5 py-3 focus:outline-none focus:border-[#FF9357] transition-all text-[#070725] font-medium">
                            <span class="absolute right-5 top-1/2 -translate-y-1/2 text-sm text-gray-500 font-medium">Bulan</span>
                        </div>
                    </div>
                    
                    <div class="bg-[#F6F7F8] rounded-2xl p-4 mt-2 flex flex-col gap-3">
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-500">Harga per bulan</p>
                            <p class="font-bold text-[#070725]">Rp {{ number_format($boardingHouse->price, 0, ',', '.') }}</p>
                        </div>
                        
                        <hr class="border-gray-200">

                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-500 font-semibold">Total Pembayaran</p>
                            <p id="total_display" class="font-bold text-[#FF9357] text-lg">
                                Rp {{ number_format($boardingHouse->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-[#070725] text-white py-4 rounded-full font-bold shadow-lg shadow-[#070725]/40 mt-4 hover:bg-[#FF9357] transition-all">
                        Lanjut ke Pembayaran
                    </button>
                </form>

            </div>
        </div>
    </div>

    <script>
        // Ambil harga dari Database PHP dan simpan ke variabel JS
        const pricePerMonth = {{ $boardingHouse->price }};

        function updateTotal() {
            // Ambil nilai durasi yang diinput user
            let duration = document.getElementById('duration').value;
            
            // Validasi: Jika kosong atau kurang dari 1, anggap 1
            if (duration < 1 || duration === "") {
                duration = 1;
            }

            // Hitung Total
            let total = pricePerMonth * duration;

            // Format ke Rupiah (Contoh: 5.000.000)
            let formattedTotal = new Intl.NumberFormat('id-ID').format(total);

            // Update teks di halaman
            document.getElementById('total_display').innerText = "Rp " + formattedTotal;
        }
    </script>
@endsection