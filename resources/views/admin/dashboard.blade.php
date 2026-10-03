<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Admin - Daftar Member</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr class="border-b font-semibold">
                            <th class="py-2 pr-4">Nama</th>
                            <th class="py-2 pr-4">Email</th>
                            <th class="py-2 pr-4">Status Akses</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($members as $member)
                            <tr class="border-b">
                                <td class="py-2 pr-4">{{ $member->nama_lengkap }}</td>
                                <td class="py-2 pr-4">{{ $member->email }}</td>
                                <td class="py-2 pr-4">
                                    @if ($member->status_akses)
                                        <span class="text-green-700 font-semibold">Aktif</span>
                                    @else
                                        <span class="text-red-700 font-semibold">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="py-2">
                                    <form method="POST" action="{{ route('admin.members.toggle-akses', $member) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="px-3 py-1 rounded text-white {{ $member->status_akses ? 'bg-red-600' : 'bg-green-600' }}">
                                            {{ $member->status_akses ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-4 text-gray-500">Belum ada member.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">{{ $members->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
