<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Member</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="mb-2">Halo, <strong>{{ Auth::user()->nama_lengkap }}</strong>!</p>

                @if (Auth::user()->status_akses)
                    <p class="mb-4 text-green-700">Akses CRUD Anda sudah aktif.</p>
                @else
                    <p class="mb-4 text-red-700">Akses CRUD belum aktif. Hubungi admin untuk mengaktifkan.</p>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('laporan-sampah.index') }}" class="block p-6 border rounded-lg hover:bg-gray-50">
                        <h3 class="font-semibold text-lg">Laporan Harian Sampah</h3>
                        <p class="text-sm text-gray-600">Catat sampah harian Anda.</p>
                    </a>
                    <a href="{{ route('catatan-tanaman.index') }}" class="block p-6 border rounded-lg hover:bg-gray-50">
                        <h3 class="font-semibold text-lg">Catatan Tanaman</h3>
                        <p class="text-sm text-gray-600">Catat tanaman beserta fotonya.</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
