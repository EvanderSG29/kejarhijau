<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $otp) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Kode OTP KejarHijau: {$this->otp}",
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: "
                <div style='font-family: Arial, sans-serif; max-width: 500px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px;'>
                    <h2 style='color: #166534; margin-top: 0;'>KejarHijau - Verifikasi OTP</h2>
                    <p style='color: #333;'>Gunakan kode 6 digit berikut untuk verifikasi akun / reset password Anda:</p>
                    <div style='background-color: #f0fdf4; border: 1px dashed #22c55e; padding: 15px; text-align: center; margin: 20px 0; border-radius: 6px;'>
                        <span style='font-size: 32px; font-weight: bold; letter-spacing: 6px; color: #15803d; font-family: monospace; user-select: all;'>{$this->otp}</span>
                    </div>
                    <p style='color: #666; font-size: 13px;'>Kode ini berlaku selama <strong>10 menit</strong>. Jangan berikan kode ini kepada siapa pun.</p>
                </div>
            ",
        );
    }
}
