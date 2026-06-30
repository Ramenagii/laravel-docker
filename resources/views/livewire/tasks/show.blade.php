<div class="py-8 px-4 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Link -->
        <a href="{{ route('projects.show', $task->project) }}" wire:navigate class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium mb-4 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to {{ $task->project->name }}
        </a>

        <!-- Task Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <!-- Task Header -->
            <div class="px-6 py-5 border-b border-slate-200">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-2">
                            <h1 class="text-xl font-bold text-slate-900">{{ $task->title }}</h1>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium
                                {{ $task->status->value === 'todo' ? 'bg-slate-100 text-slate-700' : '' }}
                                {{ $task->status->value === 'in_progress' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $task->status->value === 'review' ? 'bg-amber-100 text-amber-700' : '' }}
                                {{ $task->status->value === 'done' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                {{ $task->status->value === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                    {{ $task->status->value === 'todo' ? 'bg-slate-500' : '' }}
                                    {{ $task->status->value === 'in_progress' ? 'bg-blue-500' : '' }}
                                    {{ $task->status->value === 'review' ? 'bg-amber-500' : '' }}
                                    {{ $task->status->value === 'done' ? 'bg-emerald-500' : '' }}
                                    {{ $task->status->value === 'cancelled' ? 'bg-red-500' : '' }}">
                                </span>
                                {{ str_replace('_', ' ', ucfirst($task->status->value)) }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium
                                {{ $task->priority->value === 'urgent' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $task->priority->value === 'high' ? 'bg-orange-100 text-orange-700' : '' }}
                                {{ $task->priority->value === 'medium' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $task->priority->value === 'low' ? 'bg-slate-100 text-slate-600' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                    {{ $task->priority->value === 'urgent' ? 'bg-red-500' : '' }}
                                    {{ $task->priority->value === 'high' ? 'bg-orange-500' : '' }}
                                    {{ $task->priority->value === 'medium' ? 'bg-blue-500' : '' }}
                                    {{ $task->priority->value === 'low' ? 'bg-slate-400' : '' }}">
                                </span>
                                {{ ucfirst($task->priority->value) }} Priority
                            </span>
                        </div>
                    </div>
                    <div class="mt-3 sm:mt-0 sm:ml-4">
                        <select wire:change="updateStatus($event.target.value)" class="rounded-xl border-slate-200 text-sm py-2 pr-8 focus:border-indigo-500 focus:ring-indigo-500 bg-slate-50">
                            <option value="todo" @if($task->status->value === 'todo') selected @endif>To Do</option>
                            <option value="in_progress" @if($task->status->value === 'in_progress') selected @endif>In Progress</option>
                            <option value="review" @if($task->status->value === 'review') selected @endif>Review</option>
                            <option value="done" @if($task->status->value === 'done') selected @endif>Done</option>
                            <option value="cancelled" @if($task->status->value === 'cancelled') selected @endif>Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Task Meta -->
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50">
                <dl class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wider">Assignee</dt>
                        <dd class="mt-1.5 flex items-center text-sm text-slate-900">
                            @if($task->assignee)
                                <span class="w-6 h-6 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-semibold mr-2">{{ substr($task->assignee->name, 0, 1) }}</span>
                                {{ $task->assignee->name }}
                            @else
                                <span class="text-slate-400">Unassigned</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wider">Due Date</dt>
                        <dd class="mt-1.5 text-sm text-slate-900">{{ $task->due_date?->format('M j, Y') ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wider">Created By</dt>
                        <dd class="mt-1.5 text-sm text-slate-900">{{ $task->creator?->name ?? 'Unknown' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 uppercase tracking-wider">Created</dt>
                        <dd class="mt-1.5 text-sm text-slate-900">{{ $task->created_at->format('M j, Y') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Description -->
            @if($task->description)
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-sm font-semibold text-slate-700 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        Description
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $task->description }}</p>
                </div>
            @endif

            <!-- Tags -->
            @if($task->tags->isNotEmpty())
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-sm font-semibold text-slate-700 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Tags
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($task->tags as $tag)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium" style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Comments -->
            <div class="px-6 py-5">
                <h3 class="text-sm font-semibold text-slate-700 mb-5 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    Comments ({{ $task->comments->count() }})
                </h3>

                <div class="space-y-4 mb-6" id="comments">
                    @forelse($task->comments as $i => $comment)
                        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, {{ $i }} * 50)" x-show="show" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                             class="flex space-x-3" wire:key="{{ $comment->id }}">
                            <div class="flex-shrink-0">
                                <span class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-semibold shadow-sm">{{ substr($comment->user->name, 0, 2) }}</span>
                            </div>
                            <div class="flex-1 bg-slate-50 rounded-2xl px-4 py-3 border border-slate-200">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-semibold text-slate-900">{{ $comment->user->name }}</span>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                                        @if($comment->user_id === auth()->id() || auth()->user()->can('tasks.delete'))
                                            <button wire:click="deleteComment({{ $comment->id }})" class="text-slate-300 hover:text-red-500 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <p class="text-sm text-slate-600 leading-relaxed">{{ $comment->body }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <p class="text-sm text-slate-400">No comments yet. Start the discussion.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Add Comment -->
                <form wire:submit="addComment">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <span class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-semibold shadow-sm">{{ substr(auth()->user()->name, 0, 2) }}</span>
                        </div>
                        <div class="flex-1">
                            <textarea wire:model="newComment" rows="2" placeholder="Write a comment..." class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-sm resize-none transition-colors"></textarea>
                            @error('newComment') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors shadow-sm flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
