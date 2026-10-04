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

        <div id="foto-preview" class="mt-3 p-3 bg-emerald-50 border border-emerald-200 rounded-lg hidden">
            <div class="flex items-center justify-between">
                <p id="foto-info" class="text-sm font-semibold text-emerald-900"></p>
                <span id="foto-badge" class="px-2 py-0.5 text-xs font-bold bg-emerald-200 text-emerald-800 rounded-full">WebP Optimized</span>
            </div>
            <p id="foto-savings" class="text-xs text-emerald-700 mt-0.5">✓ Foto berhasil dikompresi di browser (hemat kuota & upload instan)</p>
            <img id="foto-img" alt="Preview Gambar" class="h-44 mt-2 rounded border object-contain bg-white shadow-sm">
        </div>

        <div id="compressing-indicator" class="mt-2 text-xs text-indigo-600 font-medium hidden flex items-center gap-1">
            <svg class="animate-spin h-4 w-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <span>Sedang mengompresi gambar ke WebP...</span>
        </div>

        <x-input-error :messages="$errors->get('foto_tanaman')" class="mt-2" />

        <script>
            document.getElementById('foto_tanaman').addEventListener('change', function () {
                const file = this.files[0];
                const box = document.getElementById('foto-preview');
                const base64Input = document.getElementById('foto_tanaman_base64');
                const img = document.getElementById('foto-img');
                const info = document.getElementById('foto-info');
                const savings = document.getElementById('foto-savings');
                const indicator = document.getElementById('compressing-indicator');
                const btnSubmit = document.getElementById('btn-submit');

                if (!file) {
                    box.classList.add('hidden');
                    base64Input.value = '';
                    return;
                }

                const originalSizeKB = (file.size / 1024).toFixed(1);
                const originalSizeMB = (file.size / 1024 / 1024).toFixed(2);
                const originalDisplay = file.size > 1024 * 1024 ? `${originalSizeMB} MB` : `${originalSizeKB} KB`;

                indicator.classList.remove('hidden');
                if (btnSubmit) btnSubmit.disabled = true;

                const reader = new FileReader();
                reader.onload = function (e) {
                    const tempImg = new Image();
                    tempImg.onload = function () {
                        // Canvas compression logic: Max width/height 1600px
                        const maxDim = 1600;
                        let width = tempImg.width;
                        let height = tempImg.height;

                        if (width > maxDim || height > maxDim) {
                            if (width > height) {
                                height = Math.round((height * maxDim) / width);
                                width = maxDim;
                            } else {
                                width = Math.round((width * maxDim) / height);
                                height = maxDim;
                            }
                        }

                        const canvas = document.createElement('canvas');
                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(tempImg, 0, 0, width, height);

                        // Export as WebP with 0.82 quality
                        let compressedDataUrl = canvas.toDataURL('image/webp', 0.82);

                        // Fallback jika browser lawas tidak support WebP di Canvas
                        if (!compressedDataUrl.startsWith('data:image/webp')) {
                            compressedDataUrl = canvas.toDataURL('image/jpeg', 0.82);
                        }

                        base64Input.value = compressedDataUrl;
                        img.src = compressedDataUrl;

                        // Calculate compressed size
                        const head = compressedDataUrl.indexOf(',');
                        const compressedBytes = Math.round((compressedDataUrl.length - head) * 3 / 4);
                        const compressedKB = (compressedBytes / 1024).toFixed(1);
                        const percentSaved = Math.max(0, Math.round((1 - (compressedBytes / file.size)) * 100));

                        info.textContent = `${file.name} (${originalDisplay} → ${compressedKB} KB)`;
                        savings.textContent = `✓ Berhasil dikompresi di HP (${percentSaved}% lebih hemat kuota). Siap diunggah cepat!`;

                        indicator.classList.add('hidden');
                        box.classList.remove('hidden');
                        if (btnSubmit) btnSubmit.disabled = false;
                    };
                    tempImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });

            // Guard against double submissions
            document.querySelector('form').addEventListener('submit', function (e) {
                const btn = document.getElementById('btn-submit');
                if (btn && !btn.disabled) {
                    btn.disabled = true;
                    btn.innerHTML = `
                        <span class="inline-flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Menyimpan ke TiDB & Cloudinary...
                        </span>
                    `;
                }
            });
        </script>
    </div>

    <div class="flex items-center gap-4 pt-2">
        <x-primary-button id="btn-submit">
            Simpan Catatan
        </x-primary-button>
        <a href="{{ route('catatan-tanaman.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900">Batal</a>
    </div>
</div>
