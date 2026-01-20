@extends('layouts.app')

@section('content')
    <div class="px-5 mt-8 mb-6">
        <h1 class="font-bold text-2xl text-[#070725]">Pengaturan Akun ⚙️</h1>
        <p class="text-gray-500 text-sm">Update profil dan keamanan akunmu.</p>
    </div>

    <div class="px-5 pb-24 flex flex-col gap-6">
        
        <div class="p-6 bg-white rounded-3xl border border-gray-100 shadow-sm">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="p-6 bg-white rounded-3xl border border-gray-100 shadow-sm">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900">Ganti Password</h2>
                    <p class="mt-1 text-sm text-gray-600">Pastikan akunmu tetap aman dengan password yang kuat.</p>
                </header>

                <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <x-input-label for="current_password" value="Password Saat Ini" />
                        <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" value="Password Baru" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" value="Ulangi Password Baru" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>Simpan Password</x-primary-button>
                        @if (session('status') === 'password-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">Berhasil disimpan.</p>
                        @endif
                    </div>
                </form>
            </section>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-gray-100 shadow-sm">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-3 rounded-full bg-red-50 text-red-600 font-bold text-sm border border-red-100 hover:bg-red-600 hover:text-white transition-all">
                    Keluar dari Aplikasi
                </button>
            </form>
        </div>

    </div>

    @include('includes.navigation')
@endsection