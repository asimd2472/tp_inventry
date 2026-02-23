<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OTPLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_request_otp_and_then_login_using_it()
    {
        Mail::fake();

        // create an active user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'status' => '1',
            'password' => bcrypt('secret'),
        ]);

        // first step: request otp
        $response = $this->postJson(route('send_otp'), [
            'username' => $user->email,
        ]);

        $response->assertStatus(200)
                 ->assertJson(['status' => 1, 'step' => 'otp']);

        // OTP should have been stored in session
        $otpData = session('login_otp');
        $this->assertNotEmpty($otpData);
        $this->assertEquals($user->email, $otpData['email']);

        // now verify using the otp
        $verify = $this->postJson(route('verify_otp'), [
            'otp' => $otpData['code'],
        ]);

        $verify->assertStatus(200)
               ->assertJson(['status' => 1]);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function invalid_otp_is_rejected()
    {
        $user = User::factory()->create(['status' => '1']);
        session(['login_otp' => ['code' => '123456', 'email' => $user->email, 'expires' => now()->addMinutes(5)]]);

        $response = $this->postJson(route('verify_otp'), ['otp' => '000000']);
        $response->assertStatus(200)->assertJson(['status' => 0]);
        $this->assertGuest();
    }
}
