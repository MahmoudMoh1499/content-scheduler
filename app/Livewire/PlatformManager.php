<?php

namespace App\Livewire;

use Livewire\Component;

class PlatformManager extends Component
{
    public $platforms = [];
    public $selectedPlatforms = [];

    public function mount()
    {
        $this->selectedPlatforms = auth()->user()->platforms()
            ->wherePivot('is_active', true)
            ->pluck('platforms.id')
            ->toArray();
    }
    public function togglePlatform($platformId)
    {
        if (in_array($platformId, $this->selectedPlatforms)) {
            $this->selectedPlatforms = array_diff($this->selectedPlatforms, [$platformId]);
        } else {
            $this->selectedPlatforms[] = $platformId;
        }
    }

    public function save()
    {
        $this->validate([
            'selectedPlatforms' => 'array',
            'selectedPlatforms.*' => 'exists:platforms,id'
        ]);

        try {
            auth()->user()->platforms()->syncWithPivotValues(
                $this->selectedPlatforms,
                ['is_active' => true]
            );

            auth()->user()->platforms()
                ->whereNotIn('platforms.id', $this->selectedPlatforms)
                ->update(['platform_user.is_active' => false]);

            $this->dispatch('notify', 'Platforms updated successfully!');
        } catch (\Exception $e) {
            $this->dispatch('notify', 'Failed to update platforms', 'error');
        }
    }

    public function render()
    {
        $this->platforms = \App\Models\Platform::all();

        return view('livewire.platform-manager');
    }
}
