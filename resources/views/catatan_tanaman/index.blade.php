<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Catatan Tanaman</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
                <a href="{{ route('catatan-tanaman.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded">+ Tambah Catatan</a>

                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr class="border-b font-semibold">
                            <th class="py-2 pr-4">Foto</th>
                            <th class="py-2 pr-4">Nama</th>
                            <th class="py-2 pr-4">Jenis</th>
                            <th class="py-2 pr-4">Lokasi</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($catatan as $item)
                            <tr class="border-b">
                                <td class="py-2 pr-4">
                                    @if ($item->foto_tanaman)
                                        <img src="{{ $item->foto_tanaman }}" alt="{{ $item->nama_tanaman }}" class="h-16 w-16 object-cover rounded">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-2 pr-4">{{ $item->nama_tanaman }}</td>
                                <td class="py-2 pr-4">{{ $item->jenis_tanaman }}</td>
                                <td class="py-2 pr-4">{{ $item->lokasi_tanaman }}</td>
                                <td class="py-2 flex gap-2">
                                    <a href="{{ route('catatan-tanaman.edit', $item) }}" class="text-indigo-600 underline">Edit</a>
                                    <form method="POST" action="{{ route('catatan-tanaman.destroy', $item) }}" onsubmit="return confirm('Hapus catatan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-4 text-gray-500">Belum ada catatan.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">{{ $catatan->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
