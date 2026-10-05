<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OtpPasswordResetController extends Controller
{
    public function __construct(private OtpService $otpService) {}

    /**
     * Tampilkan formulir permintaan OTP lupa password.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim kode OTP ke email.
     */
    public function sendOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem KejarHijau.',
        ]);

        $email = $request->input('email');
        $result = $this->otpService->generateAndSend($email);

        if (! $result['success']) {
            return back()->withInput()->with('error', 'Gagal mengirim email OTP: ' . ($result['error'] ?? 'Terjadi kesalahan.'));
        }

        return redirect()->route('password.otp.verify', ['email' => $email])
            ->with('status', 'Kode OTP 6-digit telah dikirim ke ' . $email . '. Silakan periksa kotak masuk atau spam.');
    }

    /**
     * Tampilkan formulir verifikasi OTP dan ganti password.
     */
    public function showVerifyForm(Request $request): View
    {
        $email = $request->query('email', old('email'));

        return view('auth.verify-otp', ['email' => $email]);
    }

    /**
     * Verifikasi kode OTP dan simpan password baru.
     */
    public function verifyAndReset(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'otp' => ['required', 'string', 'size:6'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'otp.size' => 'Kode OTP harus terdiri dari 6 digit angka.',
        ]);

        $email = $request->input('email');
        $otp = $request->input('otp');

        $isValid = $this->otpService->verify($email, $otp);

        if (! $isValid) {
            throw ValidationException::withMessages([
                'otp' => 'Kode OTP salah atau sudah kedaluwarsa (maksimal 10 menit).',
            ]);
        }

        // Update password user
        $user = User::where('email', $email)->first();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan masuk dengan password baru Anda.');
    }
}
