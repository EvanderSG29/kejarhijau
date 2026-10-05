<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Daftar seluruh member.
     */
    public function dashboard(): View
    {
        $members = User::select(['id_user', 'nama_lengkap', 'email', 'role', 'status_akses', 'created_at'])
            ->where('role', 'member')
            ->orderBy('nama_lengkap')
            ->paginate(15);

        return view('admin.dashboard', compact('members'));
    }

    /**
     * Toggle status_akses member (true <-> false).
     */
    public function toggleAkses(User $user): RedirectResponse
    {
        if ($user->role !== 'member') {
            return back()->with('error', 'Hanya akun member yang dapat diubah aksesnya.');
        }

        $user->status_akses = ! $user->status_akses;
        $user->save();

        $status = $user->status_akses ? 'DIAKTIFKAN' : 'DINONAKTIFKAN';

        return back()->with('success', "Akses CRUD untuk {$user->nama_lengkap} berhasil {$status}.");
    }
}
