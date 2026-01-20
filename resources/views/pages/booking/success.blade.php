@extends('layouts.app')

@section('content')
    <div class="relative min-h-screen bg-white flex flex-col items-center justify-center p-5">
        
        <div class="w-[120px] h-[120px] rounded-full bg-[#F2F9E6] flex items-center justify-center mb-6 animate-bounce">
            <img src="{{ asset('assets/images/icons/card-tick.svg') }}" class="w-16 h-16" 
                 onerror="this.src='https://api.iconify.design/solar:check-circle-bold.svg?color=%2391BF77'" 
                 alt="Success">
        </div>

        <h1 class="font-bold text-[30px] leading-[45px] text-center text-[#070725] mb-2">
            Booking Successful!
        </h1>
        <p class="text-[#83859C] text-center max-w-[300px] mb-10 leading-[30px]">
            We have received your payment and the boarding house owner will contact you soon.
        </p>

        <div class="flex flex-col gap-4 w-full max-w-[320px]">
            <a href="{{ route('dashboard') }}" class="w-full bg-[#070725] text-white py-4 rounded-full font-bold text-center hover:bg-[#FF9357] transition-all shadow-lg shadow-[#070725]/30">
                My Dashboard
            </a>
            <a href="https://wa.me/" class="w-full bg-white border border-[#F1F2F6] text-[#070725] py-4 rounded-full font-bold text-center hover:bg-gray-50 transition-all">
                Contact Support
            </a>
        </div>

    </div>
@endsection