<?php

use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

test('reset password link screen can be rendered', function () {
    $response = $this->get('/forgot-password');

    $response->assertStatus(200);
});

test('reset password otp can be requested', function () {
    Mail::fake();

    $user = User::factory()->create();

    $response = $this->post('/forgot-password', ['email' => $user->email]);

    $response->assertRedirect(route('password.otp.verify', ['email' => $user->email]));
    Mail::assertSent(OtpMail::class, function ($mail) use ($user) {
        return $mail->hasTo($user->email);
    });
});
