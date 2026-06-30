<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Show extends Component
{
    public Task $task;
    public $newComment = '';

    protected $rules = [
        'newComment' => 'required|min:1',
    ];

    public function addComment()
    {
        $this->authorize('comments.create');

        $this->validate();

        $this->task->comments()->create([
            'user_id' => auth()->id(),
            'body' => $this->newComment,
        ]);

        $this->reset('newComment');
        $this->dispatch('comment-added');
    }

    public function updateStatus($status)
    {
        $this->authorize('tasks.edit');

        $this->task->update(['status' => $status]);
        session()->flash('message', 'Task status updated.');
    }

    public function deleteComment($commentId)
    {
        $comment = $this->task->comments()->findOrFail($commentId);

        if ($comment->user_id !== auth()->id()) {
            $this->authorize('comments.delete.own');
        }

        $comment->delete();
    }

    public function render()
    {
        $this->task->load(['comments.user', 'project', 'assignee', 'tags', 'creator']);
        return view('livewire.tasks.show');
    }
}
