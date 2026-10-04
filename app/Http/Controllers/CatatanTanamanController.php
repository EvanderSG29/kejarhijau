<?php

namespace App\Http\Controllers;

use App\Models\CatatanTanaman;
use App\Services\CloudinaryUploader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class CatatanTanamanController extends Controller
{
    public function __construct(private CloudinaryUploader $uploader) {}

    public function index(Request $request): View
    {
        $query = $request->user()->isAdmin()
            ? CatatanTanaman::with('user')
            : $request->user()->catatanTanaman();

        $catatan = $query->latest()->paginate(10);

        return view('catatan_tanaman.index', compact('catatan'));
    }

    public function create(): View
    {
        return view('catatan_tanaman.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $uploadedUrl = $this->handleUpload($request);
        if ($uploadedUrl) {
            $data['foto_tanaman'] = $uploadedUrl;
        }

        $request->user()->catatanTanaman()->create($data);

        $msg = 'Catatan tanaman berhasil ditambahkan.';
        if (! empty($data['foto_tanaman'])) {
            $msg .= ' Foto tersimpan di Cloudinary: ' . $data['foto_tanaman'];
        }

        return redirect()->route('catatan-tanaman.index')->with('success', $msg);
    }

    public function edit(Request $request, CatatanTanaman $catatan_tanaman): View
    {
        $this->authorizeOwner($request, $catatan_tanaman);

        return view('catatan_tanaman.edit', ['catatan' => $catatan_tanaman]);
    }

    public function update(Request $request, CatatanTanaman $catatan_tanaman): RedirectResponse
    {
        $this->authorizeOwner($request, $catatan_tanaman);

        $data = $this->validated($request);

        $uploadedUrl = $this->handleUpload($request);
        if ($uploadedUrl) {
            $data['foto_tanaman'] = $uploadedUrl;
        }

        $catatan_tanaman->update($data);

        $msg = 'Catatan tanaman berhasil diperbarui.';
        if (! empty($data['foto_tanaman'])) {
            $msg .= ' Foto tersimpan di Cloudinary: ' . $data['foto_tanaman'];
        }

        return redirect()->route('catatan-tanaman.index')->with('success', $msg);
    }

    public function destroy(Request $request, CatatanTanaman $catatan_tanaman): RedirectResponse
    {
        $this->authorizeOwner($request, $catatan_tanaman);

        $catatan_tanaman->delete();

        return redirect()->route('catatan-tanaman.index')->with('success', 'Catatan tanaman berhasil dihapus.');
    }

    private function handleUpload(Request $request): ?string
    {
        try {
            // Jalur 1: Base64 dari FileReader (Bypass batasan PHP temp upload di Windows)
            if ($request->filled('foto_tanaman_base64') && str_starts_with($request->input('foto_tanaman_base64'), 'data:image/')) {
                return $this->uploader->upload($request->input('foto_tanaman_base64'));
            }

            // Jalur 2: Standard multipart file upload
            if ($request->hasFile('foto_tanaman') && $request->file('foto_tanaman')->isValid()) {
                return $this->uploader->upload($request->file('foto_tanaman'));
            }
        } catch (Throwable $e) {
            Log::error('Cloudinary upload exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw ValidationException::withMessages([
                'foto_tanaman' => 'Gagal mengunggah foto ke Cloudinary: ' . $e->getMessage(),
            ]);
        }

        return null;
    }

    private function validated(Request $request): array
    {
        // Jika ada base64 yang valid, kita tidak perlu validasi file multipart
        $hasBase64 = $request->filled('foto_tanaman_base64') && str_starts_with($request->input('foto_tanaman_base64'), 'data:image/');

        if (! $hasBase64) {
            $this->assertUploadOk($request);
        }

        $rules = [
            'nama_tanaman' => ['required', 'string', 'max:255'],
            'jenis_tanaman' => ['required', 'string', 'max:255'],
            'lokasi_tanaman' => ['required', 'string', 'max:255'],
            'cara_merawat' => ['required', 'string'],
        ];

        if (! $hasBase64) {
            $rules['foto_tanaman'] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'];
        }

        $data = $request->validate($rules, [
            'foto_tanaman.uploaded' => 'Foto gagal diunggah ke server.',
            'foto_tanaman.max' => 'Ukuran foto maksimal 5 MB.',
        ]);

        unset($data['foto_tanaman'], $data['foto_tanaman_base64']);

        return $data;
    }

    private function authorizeOwner(Request $request, CatatanTanaman $catatan): void
    {
        abort_unless($request->user()->isAdmin() || $catatan->id_user === $request->user()->id_user, 403);
    }

    private function assertUploadOk(Request $request): void
    {
        $file = $request->file('foto_tanaman');

        if (! $file || $file->isValid()) {
            return;
        }

        $kode = $file->getError();

        $penyebab = match ($kode) {
            UPLOAD_ERR_INI_SIZE => 'Ukuran file melebihi upload_max_filesize (sekarang: '.ini_get('upload_max_filesize').').',
            UPLOAD_ERR_FORM_SIZE => 'Ukuran file melebihi batas form.',
            UPLOAD_ERR_PARTIAL => 'File hanya terunggah sebagian (koneksi terputus). Coba lagi.',
            UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary PHP tidak ditemukan (upload_tmp_dir).',
            UPLOAD_ERR_CANT_WRITE => 'PHP tidak bisa menulis file ke folder temporary ('.sys_get_temp_dir().').',
            UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh ekstensi PHP.',
            default => 'Error upload tidak dikenal.',
        };

        Log::warning('Upload foto gagal di level PHP', ['kode' => $kode, 'penyebab' => $penyebab]);

        throw ValidationException::withMessages([
            'foto_tanaman' => "Upload gagal (kode PHP {$kode}): {$penyebab}",
        ]);
    }
}
