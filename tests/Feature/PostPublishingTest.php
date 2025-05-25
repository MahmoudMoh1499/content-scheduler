<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Platform;

class PostPublishingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_publishes_due_posts()
    {
        $post = Post::factory()
            ->scheduled()
            ->hasAttached(Platform::factory()->twitter())
            ->create(['scheduled_time' => now()->subHour()]);

        $this->artisan('posts:publish')
            ->assertExitCode(0);

        $this->assertEquals('published', $post->fresh()->status);
    }
}
