<div class="py-8 px-4 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Back Link -->
        <a href="{{ route('projects.index') }}" wire:navigate class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium mb-4 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Projects
        </a>

        <!-- Project Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">{{ $project->name }}</h1>
                    @if($project->description)
                        <p class="text-sm text-slate-500 mt-1">{{ $project->description }}</p>
                    @endif
                </div>
                <div class="mt-3 sm:mt-0 flex items-center space-x-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium
                        {{ $project->status->value === 'active' ? 'bg-emerald-100 text-emerald-700' : '' }}
                        {{ $project->status->value === 'completed' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $project->status->value === 'archived' ? 'bg-slate-100 text-slate-600' : '' }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-1.5
                            {{ $project->status->value === 'active' ? 'bg-emerald-500' : '' }}
                            {{ $project->status->value === 'completed' ? 'bg-blue-500' : '' }}
                            {{ $project->status->value === 'archived' ? 'bg-slate-400' : '' }}">
                        </span>
                        {{ ucfirst($project->status->value) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Add Task -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-6">
            <form wire:submit="createTask" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <div class="flex-1 relative">
                    <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <input type="text" wire:model="newTaskTitle" placeholder="Add a new task..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-sm transition-colors">
                </div>
                <select wire:model="newTaskPriority" class="sm:w-36 rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5">
                    <option value="low">Low Priority</option>
                    <option value="medium">Medium Priority</option>
                    <option value="high">High Priority</option>
                    <option value="urgent">Urgent</option>
                </select>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors shadow-sm whitespace-nowrap">
                    <span wire:loading.remove wire:target="createTask">Add Task</span>
                    <span wire:loading wire:target="createTask">Adding...</span>
                </button>
            </form>
            @error('newTaskTitle') <p class="text-red-500 text-xs mt-2 flex items-center"><svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
        </div>

        <!-- Kanban Board -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Todo Column -->
            <div class="bg-slate-50/80 rounded-2xl border border-slate-200 p-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 rounded-full bg-slate-500"></span>
                        <h3 class="text-sm font-semibold text-slate-700">To Do</h3>
                    </div>
                    <span class="text-xs font-semibold text-slate-500 bg-slate-200 px-2 py-0.5 rounded-full">{{ $this->todoTasks->count() }}</span>
                </div>
                <div class="space-y-3 min-h-[120px]">
                    @foreach($this->todoTasks as $task)
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-3.5 hover:shadow-md hover:border-indigo-200 transition-all duration-150 group">
                            <div class="flex items-start justify-between">
                                <a href="{{ route('tasks.show', $task) }}" wire:navigate class="text-sm font-medium text-slate-900 hover:text-indigo-600 transition-colors flex-1 mr-2">{{ $task->title }}</a>
                                <button wire:click="deleteTask({{ $task->id }})" wire:confirm="Delete this task?" class="opacity-0 group-hover:opacity-100 text-slate-300 hover:text-red-500 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium
                                    {{ $task->priority->value === 'urgent' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $task->priority->value === 'high' ? 'bg-orange-100 text-orange-700' : '' }}
                                    {{ $task->priority->value === 'medium' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $task->priority->value === 'low' ? 'bg-slate-100 text-slate-600' : '' }}">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1
                                        {{ $task->priority->value === 'urgent' ? 'bg-red-500' : '' }}
                                        {{ $task->priority->value === 'high' ? 'bg-orange-500' : '' }}
                                        {{ $task->priority->value === 'medium' ? 'bg-blue-500' : '' }}
                                        {{ $task->priority->value === 'low' ? 'bg-slate-400' : '' }}">
                                    </span>
                                    {{ ucfirst($task->priority->value) }}
                                </span>
                                <select wire:change="updateTaskStatus({{ $task->id }}, $event.target.value)" class="text-xs border-0 bg-slate-50 rounded-lg py-1 text-slate-500 focus:ring-indigo-500 cursor-pointer">
                                    <option value="todo" selected>Todo</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="review">Review</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>
                        </div>
                    @endforeach
                    <div class="text-center py-6 text-xs text-slate-400">
                        <svg class="w-8 h-8 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Drag tasks here
                    </div>
                </div>
            </div>

            <!-- In Progress Column -->
            <div class="bg-blue-50/80 rounded-2xl border border-blue-200 p-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                        <h3 class="text-sm font-semibold text-blue-700">In Progress</h3>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-200 px-2 py-0.5 rounded-full">{{ $this->inProgressTasks->count() }}</span>
                </div>
                <div class="space-y-3 min-h-[120px]">
                    @foreach($this->inProgressTasks as $task)
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-3.5 hover:shadow-md hover:border-blue-200 transition-all duration-150 group">
                            <div class="flex items-start justify-between">
                                <a href="{{ route('tasks.show', $task) }}" wire:navigate class="text-sm font-medium text-slate-900 hover:text-blue-600 transition-colors flex-1 mr-2">{{ $task->title }}</a>
                                <button wire:click="deleteTask({{ $task->id }})" wire:confirm="Delete this task?" class="opacity-0 group-hover:opacity-100 text-slate-300 hover:text-red-500 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium
                                    {{ $task->priority->value === 'urgent' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $task->priority->value === 'high' ? 'bg-orange-100 text-orange-700' : '' }}
                                    {{ $task->priority->value === 'medium' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $task->priority->value === 'low' ? 'bg-slate-100 text-slate-600' : '' }}">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1
                                        {{ $task->priority->value === 'urgent' ? 'bg-red-500' : '' }}
                                        {{ $task->priority->value === 'high' ? 'bg-orange-500' : '' }}
                                        {{ $task->priority->value === 'medium' ? 'bg-blue-500' : '' }}
                                        {{ $task->priority->value === 'low' ? 'bg-slate-400' : '' }}">
                                    </span>
                                    {{ ucfirst($task->priority->value) }}
                                </span>
                                <select wire:change="updateTaskStatus({{ $task->id }}, $event.target.value)" class="text-xs border-0 bg-blue-50 rounded-lg py-1 text-blue-600 focus:ring-blue-500 cursor-pointer">
                                    <option value="todo">Todo</option>
                                    <option value="in_progress" selected>In Progress</option>
                                    <option value="review">Review</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Review Column -->
            <div class="bg-amber-50/80 rounded-2xl border border-amber-200 p-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                        <h3 class="text-sm font-semibold text-amber-700">Review</h3>
                    </div>
                    <span class="text-xs font-semibold text-amber-600 bg-amber-200 px-2 py-0.5 rounded-full">{{ $this->reviewTasks->count() }}</span>
                </div>
                <div class="space-y-3 min-h-[120px]">
                    @foreach($this->reviewTasks as $task)
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-3.5 hover:shadow-md hover:border-amber-200 transition-all duration-150 group">
                            <div class="flex items-start justify-between">
                                <a href="{{ route('tasks.show', $task) }}" wire:navigate class="text-sm font-medium text-slate-900 hover:text-amber-600 transition-colors flex-1 mr-2">{{ $task->title }}</a>
                                <button wire:click="deleteTask({{ $task->id }})" wire:confirm="Delete this task?" class="opacity-0 group-hover:opacity-100 text-slate-300 hover:text-red-500 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium
                                    {{ $task->priority->value === 'urgent' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $task->priority->value === 'high' ? 'bg-orange-100 text-orange-700' : '' }}
                                    {{ $task->priority->value === 'medium' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $task->priority->value === 'low' ? 'bg-slate-100 text-slate-600' : '' }}">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1
                                        {{ $task->priority->value === 'urgent' ? 'bg-red-500' : '' }}
                                        {{ $task->priority->value === 'high' ? 'bg-orange-500' : '' }}
                                        {{ $task->priority->value === 'medium' ? 'bg-blue-500' : '' }}
                                        {{ $task->priority->value === 'low' ? 'bg-slate-400' : '' }}">
                                    </span>
                                    {{ ucfirst($task->priority->value) }}
                                </span>
                                <select wire:change="updateTaskStatus({{ $task->id }}, $event.target.value)" class="text-xs border-0 bg-amber-50 rounded-lg py-1 text-amber-600 focus:ring-amber-500 cursor-pointer">
                                    <option value="todo">Todo</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="review" selected>Review</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Done Column -->
            <div class="bg-emerald-50/80 rounded-2xl border border-emerald-200 p-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <h3 class="text-sm font-semibold text-emerald-700">Done</h3>
                    </div>
                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-200 px-2 py-0.5 rounded-full">{{ $this->doneTasks->count() }}</span>
                </div>
                <div class="space-y-3 min-h-[120px]">
                    @foreach($this->doneTasks as $task)
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-3.5 hover:shadow-md hover:border-emerald-200 transition-all duration-150 group">
                            <div class="flex items-start justify-between">
                                <a href="{{ route('tasks.show', $task) }}" wire:navigate class="text-sm font-medium text-slate-500 hover:text-emerald-600 transition-colors flex-1 mr-2 line-through">{{ $task->title }}</a>
                                <button wire:click="deleteTask({{ $task->id }})" wire:confirm="Delete this task?" class="opacity-0 group-hover:opacity-100 text-slate-300 hover:text-red-500 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                            <div class="mt-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-emerald-100 text-emerald-700">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Complete
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
