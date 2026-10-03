@php($item = $catatan ?? null)

<div class="space-y-4">
    <div>
        <x-input-label for="nama_tanaman" value="Nama Tanaman" />
        <x-text-input id="nama_tanaman" name="nama_tanaman" type="text" class="mt-1 block w-full"
            :value="old('nama_tanaman', $item?->nama_tanaman)" required />
        <x-input-error :messages="$errors->get('nama_tanaman')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="jenis_tanaman" value="Jenis Tanaman" />
        <x-text-input id="jenis_tanaman" name="jenis_tanaman" type="text" class="mt-1 block w-full"
            :value="old('jenis_tanaman', $item?->jenis_tanaman)" required />
        <x-input-error :messages="$errors->get('jenis_tanaman')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="lokasi_tanaman" value="Lokasi Tanaman" />
        <x-text-input id="lokasi_tanaman" name="lokasi_tanaman" type="text" class="mt-1 block w-full"
            :value="old('lokasi_tanaman', $item?->lokasi_tanaman)" required />
        <x-input-error :messages="$errors->get('lokasi_tanaman')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="cara_merawat" value="Cara Merawat" />
        <textarea id="cara_merawat" name="cara_merawat" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('cara_merawat', $item?->cara_merawat) }}</textarea>
        <x-input-error :messages="$errors->get('cara_merawat')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="foto_tanaman" value="Foto Tanaman (jpg/png/webp, maks 2MB)" />
        @if ($item?->foto_tanaman)
            <img src="{{ $item->foto_tanaman }}" alt="Foto saat ini" class="h-24 mb-2 rounded">
        @endif
        <input id="foto_tanaman" name="foto_tanaman" type="file" accept="image/*" class="mt-1 block w-full">
        <x-input-error :messages="$errors->get('foto_tanaman')" class="mt-2" />
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Simpan</x-primary-button>
        <a href="{{ route('catatan-tanaman.index') }}" class="underline text-sm text-gray-600">Batal</a>
    </div>
</div>
