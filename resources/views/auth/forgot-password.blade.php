<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Lupa password? Masukkan email Anda dan kami akan mengirimkan kode verifikasi OTP 6 digit ke email Anda.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if (session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 text-sm rounded">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.otp.send') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email Akun KejarHijau')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="contoh@gmail.com" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Kembali ke Login') }}
            </a>

            <x-primary-button>
                {{ __('Kirim Kode OTP') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
