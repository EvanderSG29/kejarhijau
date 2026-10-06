<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class OtpService
{
    /**
     * Generate 6-digit OTP, simpan ke database, dan kirim via Gmail SMTP.
     */
    public function generateAndSend(string $email): array
    {
        // 1. Generate 6 digit numeric OTP
        $otp = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = Carbon::now()->addMinutes(5);

        // 2. Hapus OTP lama untuk email ini agar tidak menumpuk
        DB::table('password_reset_otps')->where('email', $email)->delete();

        // 3. Simpan ke database
        DB::table('password_reset_otps')->insert([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => $expiresAt,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Kirim email via Laravel Mail (MailerSend API)
        try {
            Mail::to($email)->send(new \App\Mail\OtpMail($otp));

            return ['success' => true, 'otp' => $otp];
        } catch (Throwable $e) {
            Log::error('Gagal mengirim OTP via MailerSend: ' . $e->getMessage(), ['email' => $email]);
            return ['success' => false, 'error' => $e->getMessage(), 'otp' => $otp];
        }
    }

    /**
     * Validasi kode OTP yang dimasukkan user.
     */
    public function verify(string $email, string $otp): bool
    {
        $record = DB::table('password_reset_otps')
            ->where('email', $email)
            ->where('otp', trim($otp))
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (! $record) {
            return false;
        }

        // Hapus OTP setelah berhasil diverifikasi
        DB::table('password_reset_otps')->where('email', $email)->delete();

        return true;
    }
}
