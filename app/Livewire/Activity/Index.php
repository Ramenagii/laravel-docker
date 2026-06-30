<?php

namespace App\Livewire\Activity;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $activities = Activity::with('causer')
            ->when($this->search, function ($q) {
                $q->where('description', 'like', "%{$this->search}%")
                  ->orWhere('event', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(20);

        return view('livewire.activity.index', [
            'activities' => $activities,
        ]);
    }
}
