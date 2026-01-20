<x-guest-layout>
    <div class="w-full max-w-lg mx-auto bg-white/95 backdrop-blur-xl rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/20 p-8 sm:p-12 transition-all duration-300 hover:shadow-[#FF9357]/20">
        
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-[#FFF5F0] rounded-2xl mb-4 text-[#FF9357] shadow-sm">
                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M2 12L12 3L22 12" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 10V20C5 20.5304 5.21071 21.0391 5.58579 21.4142C5.96086 21.7893 6.46957 22 7 22H17C17.5304 22 18.0391 21.7893 18.4142 21.4142C18.7893 21.0391 19 20.5304 19 20V10" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 22V15H15V22" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <h2 class="text-3xl font-bold text-[#070725] tracking-tight">Welcome Back</h2>
            <p class="text-gray-500 mt-2 text-sm">Masuk untuk melanjutkan perjalanan ngekosmu</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div class="group">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Email Address</label>
                <div class="relative">
                    <input type="email" name="email" required autofocus placeholder="contoh@email.com"
                        class="w-full rounded-2xl bg-gray-50 border border-gray-200 px-5 py-4 text-[#070725] focus:bg-white focus:border-[#FF9357] focus:ring-4 focus:ring-[#FF9357]/10 transition-all outline-none" 
                        value="{{ old('email') }}">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="group" x-data="{ show: false }">
                <div class="flex justify-between items-center mb-2 ml-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-[#FF9357] hover:underline">Lupa Password?</a>
                    @endif
                </div>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" name="password" required placeholder="••••••••"
                        class="w-full rounded-2xl bg-gray-50 border border-gray-200 px-5 py-4 pr-12 text-[#070725] focus:bg-white focus:border-[#FF9357] focus:ring-4 focus:ring-[#FF9357]/10 transition-all outline-none">
                    
                    <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#FF9357] transition-colors p-1">
                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.555-4.07M6.42 6.42a3 3 0 014.242 0m2.828 2.828A3 3 0 0115 12c0 1.55-.992 2.868-2.392 3.518m-2.43.906A2.992 2.992 0 0112 15m0-12c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-1.217 3.328m-17.75 3.3l17.75-17.75"/></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <button type="submit" class="w-full bg-[#070725] text-white font-bold rounded-2xl py-4 shadow-lg shadow-[#070725]/30 hover:bg-[#FF9357] hover:shadow-[#FF9357]/40 hover:-translate-y-1 transition-all duration-300">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-[#FF9357] hover:underline">Daftar Akun Baru</a>
            </p>
        </div>
    </div>
</x-guest-layout>