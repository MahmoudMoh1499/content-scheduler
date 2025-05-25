<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;
use App\Models\Platform;

class PostList extends Component
{
    use WithPagination;

    public $statusFilter = '';
    public $platformFilter = '';
    public $dateFilter = '';

    protected $queryString = [
        'statusFilter' => ['except' => ''],
        'platformFilter' => ['except' => ''],
        'dateFilter' => ['except' => ''],
    ];

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingPlatformFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('message', 'Post deleted successfully');
    }

    public function render()
    {
        $posts = Post::query()
            ->where('user_id', auth()->id())
            ->with('platforms')
            ->when($this->statusFilter, function ($query) {
                return $query->where('status', $this->statusFilter);
            })
            ->when($this->platformFilter, function ($query) {
                return $query->whereHas('platforms', function ($q) {
                    $q->where('platforms.id', $this->platformFilter);
                });
            })
            ->when($this->dateFilter, function ($query) {
                return $query->whereDate('scheduled_time', $this->dateFilter);
            })
            ->orderBy('scheduled_time', 'desc')
            ->paginate(10);

        return view('livewire.post-list', [
            'posts' => $posts,
            'platforms' => Platform::all(),
        ]);
    }
}
