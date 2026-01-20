@extends('layouts.app')

@section('content')
<div id="Background"
    class="absolute top-0 w-full h-[230px] rounded-b-[75px] bg-[linear-gradient(180deg,#F2F9E6_0%,#D2EDE4_100%)]">
</div>

<div id="TopNav" class="relative flex items-center justify-between px-5 mt-[60px]">
    <a href="{{ route('booking.information', $boardingHouse->slug) }}"
        class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white">
        <img src="{{asset('assets/images/icons/arrow-left.svg')}}" class="w-[28px] h-[28px]" alt="icon">
    </a>
    <p class="font-semibold">Checkout Koskos</p>
    <div class="dummy-btn w-12"></div>
</div>

<div id="Header" class="relative flex items-center justify-between gap-2 px-5 mt-[18px]">
    <div class="flex flex-col w-full rounded-[30px] border border-[#F1F2F6] p-4 gap-4 bg-white">
        <div class="flex gap-4">
            <div class="flex w-[120px] h-[132px] shrink-0 rounded-[30px] bg-[#D9D9D9] overflow-hidden">
                <img src="{{ asset('storage/' . $boardingHouse->thumbnail) }}" 
                     onerror="this.src='https://images.unsplash.com/photo-1522771753035-48482dd5f3af?q=80&w=800&auto=format&fit=crop'"
                     class="w-full h-full object-cover" alt="icon">
            </div>
            
            <div class="flex flex-col gap-3 w-full">
                <p class="font-semibold text-lg leading-[27px] line-clamp-2 min-h-[54px]">
                    {{ $boardingHouse->name }}
                </p>
                <hr class="border-[#F1F2F6]">
                <div class="flex items-center gap-[6px]">
                    <img src="{{asset('assets/images/icons/location.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                    <p class="text-sm text-gray-500">{{ $boardingHouse->city->name }}</p>
                </div>
                <div class="flex items-center gap-[6px]">
                    <img src="{{asset('assets/images/icons/profile-2user.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                    <p class="text-sm text-gray-500">{{ $boardingHouse->category->name }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="accordion group flex flex-col rounded-[30px] p-5 bg-[#F5F6F8] mx-5 mt-5 overflow-hidden has-[:checked]:!h-[68px] transition-all duration-300">
    <label class="relative flex items-center justify-between cursor-pointer">
        <p class="font-semibold text-lg">Customer</p>
        <img src="{{asset('assets/images/icons/arrow-up.svg')}}"
            class="w-[28px] h-[28px] flex shrink-0 group-has-[:checked]:rotate-180 transition-all duration-300"
            alt="icon">
        <input type="checkbox" class="absolute hidden">
    </label>
    <div class="flex flex-col gap-4 pt-[22px]">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{asset('assets/images/icons/profile-2user.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                <p class="text-gray-500">Name</p>
            </div>
            <p class="font-semibold">{{ $bookingData['name'] }}</p>
        </div>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{asset('assets/images/icons/sms.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                <p class="text-gray-500">Email</p>
            </div>
            <p class="font-semibold">{{ $bookingData['email'] }}</p>
        </div>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{asset('assets/images/icons/call.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                <p class="text-gray-500">Phone</p>
            </div>
            <p class="font-semibold">{{ $bookingData['phone'] }}</p>
        </div>
    </div>
</div>

<div class="accordion group flex flex-col rounded-[30px] p-5 bg-[#F5F6F8] mx-5 mt-5 overflow-hidden has-[:checked]:!h-[68px] transition-all duration-300">
    <label class="relative flex items-center justify-between cursor-pointer">
        <p class="font-semibold text-lg">Booking</p>
        <img src="{{asset('assets/images/icons/arrow-up.svg')}}"
            class="w-[28px] h-[28px] flex shrink-0 group-has-[:checked]:rotate-180 transition-all duration-300"
            alt="icon">
        <input type="checkbox" class="absolute hidden">
    </label>
    <div class="flex flex-col gap-4 pt-[22px]">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{asset('assets/images/icons/clock.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                <p class="text-gray-500">Duration</p>
            </div>
            <p class="font-semibold">{{ $bookingData['duration'] }} Months</p>
        </div>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{asset('assets/images/icons/calendar.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                <p class="text-gray-500">Started At</p>
            </div>
            <p class="font-semibold">{{\Carbon\Carbon::parse($bookingData['start_date'])->isoFormat('D MMMM YYYY')}}</p>
        </div>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{asset('assets/images/icons/calendar.svg')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                <p class="text-gray-500">Ended At</p>
            </div>
            <p class="font-semibold">
                {{\Carbon\Carbon::parse($bookingData['start_date'])->addMonths(intval($bookingData['duration']))->isoFormat('D MMMM YYYY')}}
            </p>
        </div>
    </div>
</div>

<form action="{{ route('checkout.store', $boardingHouse->slug) }}" class="relative flex flex-col gap-6 mt-5 pt-5 pb-40" method="POST">
    @csrf
    <div id="PaymentOptions" class="flex flex-col rounded-[30px] border border-[#F1F2F6] p-5 gap-4 mx-5 bg-white">
        
        <div class="flex items-center justify-between border-b border-[#F1F2F6] gap-[18px]">
            <label class="tab-link group relative flex flex-col justify-between gap-4 w-full cursor-pointer">
                <input type="radio" name="payment_method" value="down_payment" 
                       class="absolute -z-10 opacity-0" checked onchange="switchTab('DownPayment')">
                <div class="flex items-center gap-3 mx-auto">
                    <img src="{{asset('assets/images/icons/status-orange.svg')}}" class="hidden group-has-[:checked]:block w-6 h-6" alt="icon">
                    <img src="{{asset('assets/images/icons/status.svg')}}" class="block group-has-[:checked]:hidden w-6 h-6" alt="icon">
                    <p class="font-semibold text-gray-500 group-has-[:checked]:text-[#070725]">Down Payment</p>
                </div>
                <div class="w-0 mx-auto group-has-[:checked]:w-full h-[2px] bg-[#91BF77] transition-all duration-300"></div>
            </label>
            
            <div class="h-6 w-[1px] border border-[#F1F2F6]"></div>
            
            <label class="tab-link group relative flex flex-col justify-between gap-4 w-full cursor-pointer">
                <input type="radio" name="payment_method" value="full_payment" 
                       class="absolute -z-10 opacity-0" onchange="switchTab('FullPayment')">
                <div class="flex items-center gap-3 mx-auto">
                    <img src="{{asset('assets/images/icons/diamonds-orange.svg')}}" class="hidden group-has-[:checked]:block w-6 h-6" alt="icon">
                    <img src="{{asset('assets/images/icons/diamonds.svg')}}" class="block group-has-[:checked]:hidden w-6 h-6" alt="icon">
                    <p class="font-semibold text-gray-500 group-has-[:checked]:text-[#070725]">Pay in Full</p>
                </div>
                <div class="w-0 mx-auto group-has-[:checked]:w-full h-[2px] bg-[#91BF77] transition-all duration-300"></div>
            </label>
        </div>
        
        @php
            $subtotal = $boardingHouse->price * $bookingData['duration'];
            $tax = $subtotal * 0.11;
            $insurance = $subtotal * 0.01;
            $total = $subtotal + $tax + $insurance;
            $downPayment = $total * 0.3; // 30% dari Total
        @endphp

        <div id="TabContent-Container">
            <div id="DownPayment-Tab" class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <p class="text-gray-500">Sub Total</p>
                    <p class="font-semibold">Rp {{number_format($subtotal, 0, ',', '.')}}</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-gray-500">PPN 11%</p>
                    <p class="font-semibold">Rp {{number_format($tax, 0, ',', '.')}}</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-gray-500">Insurance</p>
                    <p class="font-semibold">Rp {{number_format($insurance, 0, ',', '.')}}</p>
                </div>
                <p class="text-sm text-green-600 bg-green-50 p-3 rounded-xl border border-green-100 text-center">
                    Anda cukup membayar DP 30% sekarang.
                </p>
                <hr class="border-[#F1F2F6]">
                <div class="flex items-center justify-between">
                    <p class="text-gray-500">Grand Total (30%)</p>
                    <p class="font-bold text-[#FF9357] text-lg">Rp {{number_format($downPayment, 0, ',', '.')}}</p>
                </div>
            </div>

            <div id="FullPayment-Tab" class="flex-col gap-4 hidden">
                <div class="flex items-center justify-between">
                    <p class="text-gray-500">Sub Total</p>
                    <p class="font-semibold">Rp {{number_format($subtotal, 0, ',', '.')}}</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-gray-500">PPN 11%</p>
                    <p class="font-semibold">Rp {{number_format($tax, 0, ',', '.')}}</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-gray-500">Insurance</p>
                    <p class="font-semibold">Rp {{number_format($insurance, 0, ',', '.')}}</p>
                </div>
                <p class="text-sm text-blue-600 bg-blue-50 p-3 rounded-xl border border-blue-100 text-center">
                    Pembayaran lunas 100% di awal.
                </p>
                <hr class="border-[#F1F2F6]">
                <div class="flex items-center justify-between">
                    <p class="text-gray-500">Grand Total (100%)</p>
                    <p class="font-bold text-[#FF9357] text-lg">Rp {{number_format($total, 0, ',', '.')}}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div id="BottomNav" class="fixed bottom-0 w-full max-w-[640px] bg-white border-t border-gray-100 p-5 z-50">
        <div class="flex items-center justify-between rounded-[40px] py-4 px-6 bg-[#070725]">
            <div class="flex flex-col gap-[2px]">
                <p id="grandTotalDisplay" class="font-bold text-xl leading-[30px] text-white">
                    Rp {{number_format($downPayment, 0, ',', '.')}}
                </p>
                <span class="text-sm text-white">Grand Total</span>
            </div>
            <button type="submit" class="flex shrink-0 rounded-full py-[14px] px-5 bg-[#FF9357] font-bold text-white hover:bg-[#ff8540] transition-all">
                Pay Now
            </button>
        </div>
    </div>
</form>

<script>
    // Siapkan data harga dari PHP ke variabel JS
    const downPaymentTotal = "Rp {{number_format($downPayment, 0, ',', '.')}}";
    const fullPaymentTotal = "Rp {{number_format($total, 0, ',', '.')}}";

    function switchTab(tabName) {
        // Ambil elemen tab konten
        const dpTab = document.getElementById('DownPayment-Tab');
        const fullTab = document.getElementById('FullPayment-Tab');
        const priceDisplay = document.getElementById('grandTotalDisplay');

        if (tabName === 'DownPayment') {
            // Tampilkan Tab DP, Sembunyikan Full
            dpTab.style.display = 'flex';
            fullTab.style.display = 'none';
            // Update Harga di Tombol Bawah
            priceDisplay.innerText = downPaymentTotal;
        } else {
            // Tampilkan Tab Full, Sembunyikan DP
            dpTab.style.display = 'none';
            fullTab.style.display = 'flex';
            // Update Harga di Tombol Bawah
            priceDisplay.innerText = fullPaymentTotal;
        }
    }
</script>

@endsection