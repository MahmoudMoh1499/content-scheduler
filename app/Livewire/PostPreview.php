<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostPreview extends Component
{
    public Post $post;

    public function mount(Post $post)
    {
        $this->post = $post->load('platforms');

        if ($this->post->user_id !== auth()->id()) {
            abort(403);
        }
    }

    public function render()
    {
        return view('livewire.post-preview');
    }
}
