<?php

namespace App\Http\Controllers;

use App\Models\CatatanTanaman;
use App\Services\CloudinaryUploader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class CatatanTanamanController extends Controller
{
    public function __construct(private CloudinaryUploader $uploader) {}

    public function index(Request $request): View
    {
        $catatan = $request->user()
            ->catatanTanaman()
            ->latest()
            ->paginate(10);

        return view('catatan_tanaman.index', compact('catatan'));
    }

    public function create(): View
    {
        return view('catatan_tanaman.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        try {
            if ($request->hasFile('foto_tanaman')) {
                $data['foto_tanaman'] = $this->uploader->upload($request->file('foto_tanaman'));
            }
        } catch (Throwable $e) {
            report($e);

            return back()->withInput()->with('error', 'Gagal mengunggah foto ke Cloudinary. Coba lagi.');
        }

        $request->user()->catatanTanaman()->create($data);

        return redirect()->route('catatan-tanaman.index')->with('success', 'Catatan tanaman berhasil ditambahkan.');
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

        try {
            if ($request->hasFile('foto_tanaman')) {
                $data['foto_tanaman'] = $this->uploader->upload($request->file('foto_tanaman'));
            }
        } catch (Throwable $e) {
            report($e);

            return back()->withInput()->with('error', 'Gagal mengunggah foto ke Cloudinary. Coba lagi.');
        }

        $catatan_tanaman->update($data);

        return redirect()->route('catatan-tanaman.index')->with('success', 'Catatan tanaman berhasil diperbarui.');
    }

    public function destroy(Request $request, CatatanTanaman $catatan_tanaman): RedirectResponse
    {
        $this->authorizeOwner($request, $catatan_tanaman);

        $catatan_tanaman->delete();

        return redirect()->route('catatan-tanaman.index')->with('success', 'Catatan tanaman berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'nama_tanaman' => ['required', 'string', 'max:255'],
            'jenis_tanaman' => ['required', 'string', 'max:255'],
            'lokasi_tanaman' => ['required', 'string', 'max:255'],
            'cara_merawat' => ['required', 'string'],
            'foto_tanaman' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // File mentah tidak disimpan ke DB; diganti URL Cloudinary di atas.
        unset($data['foto_tanaman']);

        return $data;
    }

    private function authorizeOwner(Request $request, CatatanTanaman $catatan): void
    {
        abort_unless($catatan->id_user === $request->user()->id_user, 403);
    }
}
