<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Membuat 1 akun admin awal (role tidak bisa dipilih lewat registrasi).
     * Ubah password setelah login pertama!
     */
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => 'admin@kejarhijau.test']);
        $admin->nama_lengkap = 'Administrator';
        $admin->password = env('ADMIN_PASSWORD', 'ChangeMe123!');
        $admin->role = 'admin';
        $admin->status_akses = true;
        $admin->save();
    }
}
