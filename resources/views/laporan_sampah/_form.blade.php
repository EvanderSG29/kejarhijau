@php($item = $laporan ?? null)

<div class="space-y-4">
    <div>
        <x-input-label for="tanggal" value="Tanggal" />
        <x-text-input id="tanggal" name="tanggal" type="date" class="mt-1 block w-full"
            :value="old('tanggal', optional($item?->tanggal)->format('Y-m-d') ?? date('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="jenis_sampah" value="Jenis Sampah" />
        <select id="jenis_sampah" name="jenis_sampah" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="0" @selected((string) old('jenis_sampah', $item?->jenis_sampah) === '0')>Anorganik</option>
            <option value="1" @selected((string) old('jenis_sampah', $item?->jenis_sampah) === '1')>Organik</option>
        </select>
        <x-input-error :messages="$errors->get('jenis_sampah')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="jumlah" value="Jumlah" />
        <x-text-input id="jumlah" name="jumlah" type="number" step="0.01" min="0" class="mt-1 block w-full"
            :value="old('jumlah', $item?->jumlah)" required />
        <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="satuan" value="Satuan (kg, liter, dll)" />
        <x-text-input id="satuan" name="satuan" type="text" class="mt-1 block w-full"
            :value="old('satuan', $item?->satuan)" required />
        <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="tujuan_akhir" value="Tujuan Akhir" />
        <x-text-input id="tujuan_akhir" name="tujuan_akhir" type="text" class="mt-1 block w-full"
            :value="old('tujuan_akhir', $item?->tujuan_akhir)" required />
        <x-input-error :messages="$errors->get('tujuan_akhir')" class="mt-2" />
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Simpan</x-primary-button>
        <a href="{{ route('laporan-sampah.index') }}" class="underline text-sm text-gray-600">Batal</a>
    </div>
</div>
