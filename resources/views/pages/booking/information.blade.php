@extends('layouts.app')

@section('content')
<div id="Background"
    class="absolute top-0 w-full h-[230px] rounded-b-[75px] bg-[linear-gradient(180deg,#F2F9E6_0%,#D2EDE4_100%)]">
</div>

<div id="TopNav" class="relative flex items-center justify-between px-5 mt-[60px]">
    <a href="{{ route('booking.check', $boardingHouse->slug) }}"
        class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white">
        <img src="{{asset('assets/images/icons/arrow-left.svg')}}" class="w-[28px] h-[28px]" alt="icon">
    </a>
    <p class="font-semibold">Customer Information</p>
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
                    {{$boardingHouse->name}}
                </p>
                <hr class="border-[#F1F2F6]">
                <div class="flex items-center gap-[6px]">
                    <img src="{{asset('assets/images/icons/location.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                    <p class="text-sm text-gray-500">
                        {{$boardingHouse->city->name}}
                    </p>
                </div>
                <div class="flex items-center gap-[6px]">
                    <img src="{{asset('assets/images/icons/profile-2user.svg')}}" class="w-5 h-5 flex shrink-0"
                        alt="icon">
                    <p class="text-sm text-gray-500">{{$boardingHouse->category->name}}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('booking.information.store', $boardingHouse->slug) }}"
    class="relative flex flex-col gap-6 mt-5 pt-5 pb-40" 
    method="POST">
    @csrf
    
    <div class="flex flex-col gap-[6px] px-5">
        <h1 class="font-semibold text-lg">Your Information</h1>
        <p class="text-sm text-gray-500">Fill the fields below with your valid data</p>
    </div>

    <div id="InputContainer" class="flex flex-col gap-[18px]">
        <div class="flex flex-col w-full gap-2 px-5">
            <p class="font-semibold">Complete Name</p>
            <label class="flex items-center w-full rounded-full p-[14px_20px] gap-3 bg-white border border-[#F1F2F6] focus-within:ring-1 focus-within:ring-[#91BF77] transition-all duration-300">
                <img src="{{asset('assets/images/icons/profile-2user.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                <input type="text" name="name" 
                    class="appearance-none outline-none w-full font-semibold placeholder:text-gray-400 placeholder:font-normal"
                    placeholder="Write your name" value="{{ Auth::user()->name }}">
            </label>
        </div>

        <div class="flex flex-col w-full gap-2 px-5">
            <p class="font-semibold">Email Address</p>
            <label class="flex items-center w-full rounded-full p-[14px_20px] gap-3 bg-white border border-[#F1F2F6] focus-within:ring-1 focus-within:ring-[#91BF77] transition-all duration-300">
                <img src="{{asset('assets/images/icons/sms.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                <input type="email" name="email" 
                    class="appearance-none outline-none w-full font-semibold placeholder:text-gray-400 placeholder:font-normal"
                    placeholder="Write your email" value="{{ Auth::user()->email }}">
            </label>
        </div>

        <div class="flex flex-col w-full gap-2 px-5">
            <p class="font-semibold">Phone No</p>
            <label class="flex items-center w-full rounded-full p-[14px_20px] gap-3 bg-white border border-[#F1F2F6] focus-within:ring-1 focus-within:ring-[#91BF77] transition-all duration-300">
                <img src="{{asset('assets/images/icons/call.svg')}}" class="w-5 h-5 flex shrink-0" alt="icon">
                <input type="tel" name="phone" 
                    class="appearance-none outline-none w-full font-semibold placeholder:text-gray-400 placeholder:font-normal"
                    placeholder="Write your phone" value="{{ old('phone') }}">
            </label>
        </div>
    </div>

    <div id="BottomNav" class="fixed bottom-0 w-full max-w-[640px] bg-white border-t border-gray-100 p-5 z-50">
        <div class="flex items-center justify-between rounded-[40px] py-4 px-6 bg-[#070725]"> <div class="flex flex-col gap-[2px]">
                <p id="price" class="font-bold text-xl leading-[30px] text-white">
                    Rp {{ number_format($boardingHouse->price, 0, ',', '.') }}
                </p>
                <span class="text-sm text-white">Price per month</span>
            </div>
            <button type="submit"
                class="flex shrink-0 rounded-full py-[14px] px-5 bg-[#FF9357] font-bold text-white hover:bg-[#ff8540] transition-all"> Continue
            </button>
        </div>
    </div>
</form>
@endsection