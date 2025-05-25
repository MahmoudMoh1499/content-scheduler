<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class PublishScheduledPosts extends Command
{
    protected $signature = 'posts:publish';
    protected $description = 'Publish scheduled posts that are due';

    public function handle()
    {
        $posts = Post::with('platforms')
            ->where('status', 'scheduled')
            ->where('scheduled_time', '<=', now())
            ->get();

        foreach ($posts as $post) {
            $this->publishPost($post);
        }

        $this->info("Published {$posts->count()} posts.");
    }

    protected function publishPost(Post $post)
    {
        // Mock publishing to each platform
        foreach ($post->platforms as $platform) {
            $success = $this->mockPublishToPlatform($post, $platform);

            $post->platforms()->updateExistingPivot($platform->id, [
                'platform_status' => $success ? 'published' : 'failed',
                'platform_response' => $success
                    ? ['message' => 'Successfully published']
                    : ['error' => 'Failed to publish']
            ]);
        }

        $post->update(['status' => 'published']);
    }

    protected function mockPublishToPlatform(Post $post, $platform)
    {
        // In a real app, this would call the platform's API
        // Here we'll simulate a 90% success rate
        return rand(1, 10) <= 9;
    }
}
