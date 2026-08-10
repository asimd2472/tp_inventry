<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class DealerEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function dealer_email_submission_requires_a_valid_email_address()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('admin.send_dealers'), [
                'email' => 'not-an-email',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function dealer_email_submission_sends_the_dealer_file_when_available()
    {
        Mail::fake();

        $user = User::factory()->create();
        $galleryDir = public_path('gallery');
        if (!is_dir($galleryDir)) {
            mkdir($galleryDir, 0777, true);
        }

        $fileName = 'dealer-list.pdf';
        file_put_contents($galleryDir . '/' . $fileName, 'dealer list content');

        Gallery::create([
            'type' => 'dealers',
            'file_name' => $fileName,
        ]);

        $response = $this->actingAs($user)
            ->postJson(route('admin.send_dealers'), [
                'email' => 'dealer@example.com',
            ]);

        $response->assertStatus(200)
            ->assertJson(['status' => 1]);

        Mail::assertSentCount(1);
    }
}
