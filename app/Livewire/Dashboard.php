<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public $viewMode = 'calendar';
    public $statusFilter = '';
    public $platformFilter = '';
    public $dateFilter = '';

    protected $queryString = [
        'viewMode' => ['except' => 'calendar'],
        'statusFilter' => ['except' => ''],
        'platformFilter' => ['except' => ''],
        'dateFilter' => ['except' => '']
    ];

    public function changeView($view)
    {
        $this->viewMode = $view;
        $this->resetPage();
    }

    public function getPostsProperty()
    {
        return Post::query()
            ->where('user_id', auth()->id())
            ->with('platforms')
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->platformFilter, fn($q) => $q->whereHas(
                'platforms',
                fn($q) => $q->where('platforms.id', $this->platformFilter)
            ))
            ->when($this->dateFilter, fn($q) => $q->whereDate('scheduled_time', $this->dateFilter))
            ->orderBy('scheduled_time');
    }

    public function render()
    {
        $postsQuery = $this->posts;

        return view('livewire.dashboard', [
            'posts' => $postsQuery->paginate(10),
            'platforms' => \App\Models\Platform::all(),
            'stats' => $this->getStats()
        ]);
    }




    protected function getStats()
    {
        return [
            'total' => Post::where('user_id', auth()->id())->count(),
            'scheduled' => Post::where('user_id', auth()->id())
                ->where('status', 'scheduled')->count(),
            'published' => Post::where('user_id', auth()->id())
                ->where('status', 'published')->count(),
            'drafts' => Post::where('user_id', auth()->id())
                ->where('status', 'draft')->count(),
        ];
    }

    public function getCalendarEventsProperty()
    {
        return $this->posts->get()->map(function ($post) {
            return [
                'title' => $post->title,
                'start' => $post->scheduled_time,
                'color' => match ($post->status) {
                    'published' => '#10B981',
                    'scheduled' => '#F59E0B',
                    default => '#6B7280'
                },
                'extendedProps' => [
                    'content' => $post->content,
                    'platforms' => $post->platforms,
                    'image' => $post->image_url
                ]
            ];
        });
    }
}
