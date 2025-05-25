<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Platform;
use Livewire\WithFileUploads;

class PostScheduler extends Component
{

    use WithFileUploads;

    public $title = '';
    public $content = '';
    public $image;
    public $scheduled_time;
    public $selectedPlatforms = [];
    public $characterCount = 0;
    public $maxChars = 280;

    protected $rules = [
        'title' => 'required|max:100',
        'content' => 'required|string|min:1|max:280',
        'scheduled_time' => 'required|date|after:now',
        'selectedPlatforms' => 'required|array|min:1',
        'image' => 'nullable|image|max:2048',
    ];

    public function updatedSelectedPlatforms($value)
    {
        $platformIds = is_array($value) ? $value : [$value];

        $platformIds = array_filter($platformIds);

        if (empty($platformIds)) {
            $this->maxChars = 280;
            return;
        }

        $this->maxChars = Platform::whereIn('id', $platformIds)
            ->min('character_limit') ?? 280;
    }

    public function updatedContent($value)
    {
        $this->characterCount = strlen($value);
        $this->dispatch('content-updated', content: $value);
    }

    public function updatedImage()
    {
        $this->dispatch(
            'image-updated',
            url: $this->image?->temporaryUrl()
        );
    }

    public function save()
    {
        $this->validate();

        $userId = auth()->id();
        $today = \Carbon\Carbon::today();
        $tomorrow = \Carbon\Carbon::tomorrow();

        $scheduledCount = Post::where('user_id', $userId)
            ->where('status', 'scheduled')
            ->whereBetween('scheduled_time', [$today, $tomorrow])
            ->count();

        if ($scheduledCount >= 10) {
            $this->addError('rateLimit', 'You can only schedule up to 10 posts per day.');
            return;
        }

        $post = Post::create([
            'user_id' => $userId,
            'title' => $this->title,
            'content' => $this->content,
            'scheduled_time' => $this->scheduled_time,
            'status' => 'scheduled',
            'image_url' => $this->image ? $this->image->store('post-images', 'public') : null,
        ]);

        $post->platforms()->attach($this->selectedPlatforms);

        session()->flash('message', 'Post scheduled successfully!');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.post-scheduler', [
            'platforms' => Platform::all(),
        ]);
    }
}
