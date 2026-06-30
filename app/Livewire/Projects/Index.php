<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $showCreateModal = false;
    public $name = '';
    public $description = '';

    protected $rules = [
        'name' => 'required|max:255',
        'description' => 'nullable',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    #[Computed]
    public function projects()
    {
        return Project::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->withCount('tasks')
            ->latest()
            ->paginate(10);
    }

    public function create()
    {
        $this->authorize('projects.create');

        $this->validate();

        Project::create([
            'name' => $this->name,
            'description' => $this->description,
            'created_by' => auth()->id(),
        ]);

        $this->reset(['name', 'description', 'showCreateModal']);
        session()->flash('message', 'Project created successfully.');
    }

    public function render()
    {
        return view('livewire.projects.index');
    }
}
