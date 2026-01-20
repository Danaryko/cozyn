@extends('layouts.app')

@section('content')
    <div class="relative min-h-screen bg-white flex flex-col pb-24">
        
        <div class="px-5 pt-[60px] pb-4 bg-white border-b border-[#F1F2F6]">
            <h1 class="font-bold text-2xl text-[#070725]">Riwayat Booking</h1>
            <p class="text-gray-500 text-sm mt-1">Status penyewaan kos kamu.</p>
        </div>

        <div class="flex flex-col px-5 mt-5 gap-4">
            @forelse($transactions as $transaction)
                <div class="flex flex-col rounded-[20px] border border-[#F1F2F6] p-4 bg-white shadow-sm hover:border-[#FF9357] transition-all">
                    
                    <div class="flex justify-between items-center mb-3">
                        <div class="flex items-center gap-2">
                            @php
                                $statusColor = 'bg-gray-100 text-gray-500';
                                $statusText = $transaction->payment_status;
                                if($transaction->payment_status == 'pending') {
                                    $statusColor = 'bg-orange-100 text-[#FF9357]';
                                    $statusText = 'Menunggu Pembayaran';
                                } elseif($transaction->payment_status == 'success') {
                                    $statusColor = 'bg-green-100 text-green-600';
                                    $statusText = 'Berhasil';
                                } elseif($transaction->payment_status == 'failed') {
                                    $statusColor = 'bg-red-100 text-red-600';
                                    $statusText = 'Gagal';
                                }
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $statusColor }}">
                                {{ strtoupper($statusText) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-400">
                            {{ \Carbon\Carbon::parse($transaction->created_at)->isoFormat('D MMM YYYY') }}
                        </p>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-[80px] h-[80px] rounded-2xl overflow-hidden bg-gray-200 shrink-0">
                            <img src="{{ asset('storage/' . $transaction->boardingHouse->thumbnail) }}" 
                                 class="w-full h-full object-cover" alt="thumbnail">
                        </div>
                        <div class="flex flex-col gap-1 w-full">
                            <h3 class="font-bold text-[#070725] line-clamp-1">
                                {{ $transaction->boardingHouse->name }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                {{ $transaction->duration }} Bulan &bull; {{ $transaction->payment_method == 'full_payment' ? 'Full Payment' : 'Down Payment' }}
                            </p>
                            <p class="font-bold text-[#FF9357] mt-auto">
                                Rp {{ number_format($transaction->transaction_total, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    @if($transaction->payment_status == 'pending')
                        <hr class="border-dashed border-gray-200 my-3">
                        <a href="https://app.sandbox.midtrans.com/snap/v2/vtweb/{{ $transaction->snap_token }}" 
                           class="w-full py-2 bg-[#070725] text-white text-center rounded-full font-bold text-sm hover:bg-[#FF9357] transition-all">
                            Lanjut Bayar
                        </a>
                    @endif
                </div>
            @empty
                <div class="flex flex-col items-center justify-center mt-20 text-center">
                    <div class="w-20 h-20 bg-[#F5F6F8] rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h3 class="font-bold text-lg text-[#070725]">Belum ada transaksi</h3>
                    <p class="text-gray-500 text-sm max-w-[250px] mt-1">
                        Kamu belum pernah melakukan booking kos.
                    </p>
                    <a href="{{ route('dashboard') }}" class="mt-6 px-8 py-3 bg-[#FF9357] text-white rounded-full font-bold shadow-lg shadow-[#FF9357]/30">
                        Cari Kost
                    </a>
                </div>
            @endforelse
        </div>
        
        @include('includes.navigation') 
    </div>
@endsection