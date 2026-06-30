<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('projects.show', $task->project) }}" wire:navigate class="text-sm text-indigo-600 hover:text-indigo-800">&larr; Back to {{ $task->project->name }}</a>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mt-4">
            <div class="px-6 py-5 border-b border-gray-200">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h1 class="text-xl font-bold text-gray-900">{{ $task->title }}</h1>
                        <div class="flex items-center space-x-3 mt-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $task->status->value === 'todo' ? 'bg-gray-100 text-gray-800' : '' }}
                                {{ $task->status->value === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $task->status->value === 'review' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $task->status->value === 'done' ? 'bg-green-100 text-green-800' : '' }}">
                                {{ str_replace('_', ' ', ucfirst($task->status->value)) }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $task->priority->value === 'urgent' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $task->priority->value === 'high' ? 'bg-orange-100 text-orange-800' : '' }}
                                {{ $task->priority->value === 'medium' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $task->priority->value === 'low' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst($task->priority->value) }}
                            </span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <select wire:change="updateStatus($event.target.value)" class="rounded-lg border-gray-300 text-sm">
                            <option value="todo" @if($task->status->value === 'todo') selected @endif>Todo</option>
                            <option value="in_progress" @if($task->status->value === 'in_progress') selected @endif>In Progress</option>
                            <option value="review" @if($task->status->value === 'review') selected @endif>Review</option>
                            <option value="done" @if($task->status->value === 'done') selected @endif>Done</option>
                            <option value="cancelled" @if($task->status->value === 'cancelled') selected @endif>Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-b border-gray-200">
                <dl class="grid grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Assignee</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $task->assignee?->name ?? 'Unassigned' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Due Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $task->due_date?->format('M j, Y') ?? 'No due date' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Created By</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $task->creator?->name ?? 'Unknown' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Created</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $task->created_at->format('M j, Y') }}</dd>
                    </div>
                </dl>
            </div>

            @if($task->description)
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Description</h3>
                    <p class="text-sm text-gray-600">{{ $task->description }}</p>
                </div>
            @endif

            @if($task->tags->isNotEmpty())
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($task->tags as $tag)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="px-6 py-4">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Comments</h3>
                <div class="space-y-4 mb-6" id="comments">
                    @forelse($task->comments as $comment)
                        <div class="flex space-x-3" wire:key="{{ $comment->id }}">
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-medium text-gray-600">{{ substr($comment->user->name, 0, 2) }}</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</span>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        @if($comment->user_id === auth()->id() || auth()->user()->can('tasks.delete'))
                                            <button wire:click="deleteComment({{ $comment->id }})" class="text-red-400 hover:text-red-600">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $comment->body }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No comments yet.</p>
                    @endforelse
                </div>

                <form wire:submit="addComment">
                    <div class="flex items-start space-x-3">
                        <div class="flex-1">
                            <textarea wire:model="newComment" rows="2" placeholder="Add a comment..." class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" wire:keydown.enter="$wire.addComment()"></textarea>
                            @error('newComment') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
