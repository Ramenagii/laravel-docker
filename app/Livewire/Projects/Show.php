<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('layouts.app')]
class Show extends Component
{
    public Project $project;
    public $newTaskTitle = '';
    public $newTaskPriority = 'medium';

    protected $rules = [
        'newTaskTitle' => 'required|max:255',
        'newTaskPriority' => 'required|in:low,medium,high,urgent',
    ];

    #[Computed]
    public function todoTasks()
    {
        return $this->project->tasks()->where('status', 'todo')->orderBy('order_column')->get();
    }

    #[Computed]
    public function inProgressTasks()
    {
        return $this->project->tasks()->where('status', 'in_progress')->orderBy('order_column')->get();
    }

    #[Computed]
    public function reviewTasks()
    {
        return $this->project->tasks()->where('status', 'review')->orderBy('order_column')->get();
    }

    #[Computed]
    public function doneTasks()
    {
        return $this->project->tasks()->where('status', 'done')->orderBy('order_column')->get();
    }

    public function createTask()
    {
        $this->authorize('tasks.create');

        $this->validate();

        $this->project->tasks()->create([
            'title' => $this->newTaskTitle,
            'priority' => $this->newTaskPriority,
            'status' => 'todo',
            'created_by' => auth()->id(),
            'order_column' => $this->project->tasks()->where('status', 'todo')->count(),
        ]);

        $this->reset('newTaskTitle');
        session()->flash('message', 'Task created.');
    }

    public function updateTaskStatus($taskId, $status)
    {
        $task = Task::findOrFail($taskId);

        $this->authorize('tasks.edit');

        $task->update(['status' => $status]);
    }

    public function deleteTask($taskId)
    {
        $task = Task::findOrFail($taskId);

        $this->authorize('tasks.delete');

        $task->delete();
        session()->flash('message', 'Task deleted.');
    }

    public function render()
    {
        return view('livewire.projects.show');
    }
}
