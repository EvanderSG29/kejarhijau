<?php

namespace App\Http\Controllers;

use App\Models\LaporanHarianSampah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanSampahController extends Controller
{
    public function index(Request $request): View
    {
        $laporan = $request->user()
            ->laporanHarianSampah()
            ->orderByDesc('tanggal')
            ->paginate(10);

        return view('laporan_sampah.index', compact('laporan'));
    }

    public function create(): View
    {
        return view('laporan_sampah.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->user()->laporanHarianSampah()->create($this->validated($request));

        return redirect()->route('laporan-sampah.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function edit(Request $request, LaporanHarianSampah $laporan_sampah): View
    {
        $this->authorizeOwner($request, $laporan_sampah);

        return view('laporan_sampah.edit', ['laporan' => $laporan_sampah]);
    }

    public function update(Request $request, LaporanHarianSampah $laporan_sampah): RedirectResponse
    {
        $this->authorizeOwner($request, $laporan_sampah);

        $laporan_sampah->update($this->validated($request));

        return redirect()->route('laporan-sampah.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Request $request, LaporanHarianSampah $laporan_sampah): RedirectResponse
    {
        $this->authorizeOwner($request, $laporan_sampah);

        $laporan_sampah->delete();

        return redirect()->route('laporan-sampah.index')->with('success', 'Laporan berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'tanggal' => ['required', 'date'],
            'jenis_sampah' => ['required', 'boolean'],
            'jumlah' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'satuan' => ['required', 'string', 'max:50'],
            'tujuan_akhir' => ['required', 'string', 'max:255'],
        ]);
    }

    /** Member hanya boleh mengubah/menghapus data miliknya sendiri. */
    private function authorizeOwner(Request $request, LaporanHarianSampah $laporan): void
    {
        abort_unless($laporan->id_user === $request->user()->id_user, 403);
    }
}
