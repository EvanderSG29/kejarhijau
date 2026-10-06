<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Harian Sampah</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
                <a href="{{ route('laporan-sampah.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded">+ Tambah Laporan</a>

                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr class="border-b font-semibold">
                            @if (Auth::user()->isAdmin())<th class="py-2 pr-4">Pemilik</th>@endif
                            <th class="py-2 pr-4">Tanggal</th>
                            <th class="py-2 pr-4">Jenis</th>
                            <th class="py-2 pr-4">Jumlah</th>
                            <th class="py-2 pr-4">Tujuan Akhir</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporan as $item)
                            <tr class="border-b">
                                @if (Auth::user()->isAdmin())<td class="py-2 pr-4">{{ $item->user->nama_lengkap ?? '-' }}</td>@endif
                                <td class="py-2 pr-4">{{ $item->tanggal->format('d-m-Y') }}</td>
                                <td class="py-2 pr-4">{{ $item->jenis_sampah ? 'Organik' : 'Anorganik' }}</td>
                                <td class="py-2 pr-4">{{ $item->jumlah }} {{ $item->satuan }}</td>
                                <td class="py-2 pr-4">{{ $item->tujuan_akhir }}</td>
                                <td class="py-2 flex gap-2">
                                    <a href="{{ route('laporan-sampah.edit', $item) }}" class="text-indigo-600 underline">Edit</a>
                                    <form method="POST" action="{{ route('laporan-sampah.destroy', $item) }}" onsubmit="return confirm('Hapus laporan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-4 text-gray-500">Belum ada laporan.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">{{ $laporan->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
