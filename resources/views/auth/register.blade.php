<x-guest-layout>
    <div class="w-full max-w-lg mx-auto bg-white/95 backdrop-blur-xl rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/20 p-8 sm:p-10 transition-all duration-300 hover:shadow-[#FF9357]/20">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-[#FFF5F0] rounded-2xl mb-4 text-[#FF9357] shadow-sm">
                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
            </div>
            <h2 class="text-2xl font-bold text-[#070725] tracking-tight">Buat Akun Baru</h2>
            <p class="text-gray-500 mt-2 text-sm">Bergabunglah dan temukan kos impianmu</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div class="group">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Nama Lengkap</label>
                <input type="text" name="name" required autofocus placeholder="John Doe"
                    class="w-full rounded-2xl bg-gray-50 border border-gray-200 px-5 py-4 text-[#070725] focus:bg-white focus:border-[#FF9357] focus:ring-4 focus:ring-[#FF9357]/10 transition-all outline-none" 
                    value="{{ old('name') }}">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="group">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Email Address</label>
                <input type="email" name="email" required placeholder="contoh@email.com"
                    class="w-full rounded-2xl bg-gray-50 border border-gray-200 px-5 py-4 text-[#070725] focus:bg-white focus:border-[#FF9357] focus:ring-4 focus:ring-[#FF9357]/10 transition-all outline-none" 
                    value="{{ old('email') }}">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="group" x-data="{ show: false }">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Password</label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" name="password" required placeholder="Minimal 8 karakter"
                        class="w-full rounded-2xl bg-gray-50 border border-gray-200 px-5 py-4 pr-12 text-[#070725] focus:bg-white focus:border-[#FF9357] focus:ring-4 focus:ring-[#FF9357]/10 transition-all outline-none">
                    
                    <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#FF9357] transition-colors p-1">
                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.555-4.07M6.42 6.42a3 3 0 014.242 0m2.828 2.828A3 3 0 0115 12c0 1.55-.992 2.868-2.392 3.518m-2.43.906A2.992 2.992 0 0112 15m0-12c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-1.217 3.328m-17.75 3.3l17.75-17.75"/></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="group">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required placeholder="Ulangi password"
                    class="w-full rounded-2xl bg-gray-50 border border-gray-200 px-5 py-4 text-[#070725] focus:bg-white focus:border-[#FF9357] focus:ring-4 focus:ring-[#FF9357]/10 transition-all outline-none">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button type="submit" class="w-full bg-[#070725] text-white font-bold rounded-2xl py-4 shadow-lg shadow-[#070725]/30 hover:bg-[#FF9357] hover:shadow-[#FF9357]/40 hover:-translate-y-1 transition-all duration-300 mt-2">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-[#FF9357] hover:underline">Masuk disini</a>
            </p>
        </div>
    </div>
</x-guest-layout>