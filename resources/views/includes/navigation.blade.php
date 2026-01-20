<nav class="sticky top-0 z-50 w-full bg-white/70 backdrop-blur-lg border-b border-gray-100/50 transition-all duration-300">
    <div class="max-w-screen-2xl mx-auto px-4 md:px-8 h-24 flex items-center justify-between">
        
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
            <div class="w-12 h-12 bg-gradient-to-tr from-[#FF9357] to-[#FF6B2B] rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-orange-500/30 group-hover:shadow-orange-500/50 transition-all">
                C
            </div>
            <span class="font-bold text-2xl text-[#070725] tracking-tight group-hover:text-[#FF9357] transition-colors">Cozyn</span>
        </a>

        <div class="hidden md:flex items-center gap-10 bg-white/50 px-8 py-3 rounded-full border border-gray-100/50 shadow-sm">
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold {{ request()->routeIs('dashboard') ? 'text-[#FF9357]' : 'text-gray-500 hover:text-[#070725]' }} transition-colors">
                Beranda
            </a>
            <a href="{{ route('my-favorites') }}" class="text-sm font-semibold {{ request()->routeIs('my-favorites') ? 'text-[#FF9357]' : 'text-gray-500 hover:text-[#070725]' }} transition-colors">
                Favorit
            </a>
            <a href="{{ route('my-orders') }}" class="text-sm font-semibold {{ request()->routeIs('my-orders') ? 'text-[#FF9357]' : 'text-gray-500 hover:text-[#070725]' }} transition-colors">
                Riwayat Booking
            </a>
        </div>

        <div class="flex items-center gap-4">
            @auth
                <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                    <div class="text-right hidden lg:block">
                        <p class="text-sm font-bold text-[#070725]">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-gray-400 font-medium">Member</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="w-12 h-12 rounded-full p-1 border border-gray-200 hover:border-[#FF9357] transition-all">
                        <div class="w-full h-full rounded-full bg-[#FF9357] flex items-center justify-center text-white font-bold text-lg">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </a>
                </div>
            @else
                <a href="{{ route('login') }}" class="px-8 py-3 rounded-full bg-[#070725] text-white font-bold text-sm hover:bg-[#FF9357] hover:shadow-lg hover:shadow-orange-500/30 transition-all duration-300">
                    Masuk
                </a>
            @endauth
        </div>
    </div>
</nav>