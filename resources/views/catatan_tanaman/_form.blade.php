@php($item = $catatan ?? null)

<div class="space-y-4">
    <div>
        <x-input-label for="nama_tanaman" value="Nama Tanaman" />
        <x-text-input id="nama_tanaman" name="nama_tanaman" type="text" class="mt-1 block w-full"
            :value="old('nama_tanaman', $item?->nama_tanaman)" required placeholder="Contoh: Lidah Mertua" />
        <x-input-error :messages="$errors->get('nama_tanaman')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="jenis_tanaman" value="Jenis Tanaman" />
        <x-text-input id="jenis_tanaman" name="jenis_tanaman" type="text" class="mt-1 block w-full"
            :value="old('jenis_tanaman', $item?->jenis_tanaman)" required placeholder="Contoh: Hias / Herbal / Pohon" />
        <x-input-error :messages="$errors->get('jenis_tanaman')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="lokasi_tanaman" value="Lokasi Tanaman" />
        <x-text-input id="lokasi_tanaman" name="lokasi_tanaman" type="text" class="mt-1 block w-full"
            :value="old('lokasi_tanaman', $item?->lokasi_tanaman)" required placeholder="Contoh: Halaman Depan / Balkon" />
        <x-input-error :messages="$errors->get('lokasi_tanaman')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="cara_merawat" value="Cara Merawat" />
        <textarea id="cara_merawat" name="cara_merawat" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required placeholder="Contoh: Siram setiap pagi dan beri pupuk kompos seminggu sekali.">{{ old('cara_merawat', $item?->cara_merawat) }}</textarea>
        <x-input-error :messages="$errors->get('cara_merawat')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="foto_tanaman" value="Foto Tanaman (jpg/png/webp, maks 5MB)" />
        
        @if ($item?->foto_tanaman)
            <div class="mb-3 p-3 bg-gray-50 border rounded">
                <p class="text-xs text-gray-500 mb-1 font-semibold">Foto saat ini (Cloudinary):</p>
                <img src="{{ $item->foto_tanaman }}" alt="Foto saat ini" class="h-28 rounded shadow-sm object-cover">
                <a href="{{ $item->foto_tanaman }}" target="_blank" class="mt-1 inline-block text-xs text-indigo-600 underline">Lihat gambar penuh di Cloudinary</a>
            </div>
        @endif

        <input id="foto_tanaman" name="foto_tanaman" type="file" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full border p-2 rounded">
        <input type="hidden" name="foto_tanaman_base64" id="foto_tanaman_base64">

        <div id="foto-preview" class="mt-3 p-3 bg-green-50 border border-green-200 rounded hidden">
            <p id="foto-info" class="text-sm font-semibold text-green-900"></p>
            <p class="text-xs text-green-700 mt-0.5">✓ Gambar siap diunggah langsung ke Cloudinary</p>
            <img id="foto-img" alt="Preview Gambar" class="h-44 mt-2 rounded border object-contain bg-white">
        </div>

        <x-input-error :messages="$errors->get('foto_tanaman')" class="mt-2" />

        <script>
            document.getElementById('foto_tanaman').addEventListener('change', function () {
                const file = this.files[0];
                const box = document.getElementById('foto-preview');
                const base64Input = document.getElementById('foto_tanaman_base64');
                const img = document.getElementById('foto-img');
                const info = document.getElementById('foto-info');

                if (!file) {
                    box.classList.add('hidden');
                    base64Input.value = '';
                    return;
                }

                const sizeMB = (file.size / 1024 / 1024).toFixed(2);
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran foto melebihi batas 5 MB (' + sizeMB + ' MB). Silakan pilih foto lain.');
                    this.value = '';
                    box.classList.add('hidden');
                    base64Input.value = '';
                    return;
                }

                // Baca file ke Base64 (bypasses Windows temp upload limitation)
                const reader = new FileReader();
                reader.onload = function (e) {
                    base64Input.value = e.target.result;
                    img.src = e.target.result;
                    info.textContent = 'Foto Terpilih: ' + file.name + ' (' + sizeMB + ' MB)';
                    box.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            });
        </script>
    </div>

    <div class="flex items-center gap-4 pt-2">
        <x-primary-button id="btn-submit" onclick="if(document.querySelector('form').checkValidity()){ this.innerText='Menyimpan & Mengunggah...'; }">
            Simpan Catatan
        </x-primary-button>
        <a href="{{ route('catatan-tanaman.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900">Batal</a>
    </div>
</div>
