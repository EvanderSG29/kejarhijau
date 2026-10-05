<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Masukkan kode OTP 6 digit yang telah dikirimkan ke email Anda, lalu tentukan password baru.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if (session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 text-sm rounded">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.otp.update') }}">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-50" type="email" name="email" :value="old('email', $email)" required readonly />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Kode OTP 6 Digit -->
        <div class="mt-4">
            <x-input-label for="otp" :value="__('Kode OTP (6 Digit)')" />
            <x-text-input id="otp" class="block mt-1 w-full text-center tracking-widest text-2xl font-mono font-bold uppercase" type="text" name="otp" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" placeholder="123456" :value="old('otp')" required autofocus autocomplete="one-time-code" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <!-- Password Baru -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password Baru')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Konfirmasi Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Kembali ke Login') }}
            </a>

            <x-primary-button>
                {{ __('Simpan Password Baru') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 pt-4 border-t text-center">
        <form method="POST" action="{{ route('password.otp.send') }}" class="inline">
            @csrf
            <input type="hidden" name="email" value="{{ old('email', $email) }}">
            <button type="submit" class="text-xs text-indigo-600 underline hover:text-indigo-800">
                {{ __('Belum menerima kode? Kirim Ulang OTP') }}
            </button>
        </form>
    </div>
</x-guest-layout>
