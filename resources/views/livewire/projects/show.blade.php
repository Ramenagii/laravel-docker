<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('projects.index') }}" wire:navigate class="text-sm text-indigo-600 hover:text-indigo-800">&larr; Back to Projects</a>
            <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ $project->name }}</h1>
            @if($project->description)
                <p class="text-gray-500 mt-1">{{ $project->description }}</p>
            @endif
        </div>

        <!-- Quick Add Task -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <form wire:submit="createTask" class="flex items-center gap-3">
                <input type="text" wire:model="newTaskTitle" placeholder="Add a new task..." class="flex-1 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                <select wire:model="newTaskPriority" class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="urgent">Urgent</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">Add</button>
            </form>
            @error('newTaskTitle') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Kanban Board -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Todo -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-4">Todo ({{ $this->todoTasks->count() }})</h3>
                <div class="space-y-3">
                    @foreach($this->todoTasks as $task)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3">
                            <a href="{{ route('tasks.show', $task) }}" wire:navigate class="text-sm font-medium text-gray-900 hover:text-indigo-600">{{ $task->title }}</a>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs px-2 py-0.5 rounded-full {{ $task->priority === 'urgent' ? 'bg-red-100 text-red-700' : ($task->priority === 'high' ? 'bg-orange-100 text-orange-700' : ($task->priority === 'medium' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700')) }}">{{ ucfirst($task->priority) }}</span>
                                <div class="flex items-center space-x-1">
                                    <select wire:change="updateTaskStatus({{ $task->id }}, $event.target.value)" class="text-xs border-gray-200 rounded">
                                        <option value="todo" selected>Todo</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="review">Review</option>
                                        <option value="done">Done</option>
                                    </select>
                                    <button wire:click="deleteTask({{ $task->id }})" wire:confirm="Delete this task?" class="text-red-400 hover:text-red-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- In Progress -->
            <div class="bg-blue-50 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-blue-700 uppercase tracking-wider mb-4">In Progress ({{ $this->inProgressTasks->count() }})</h3>
                <div class="space-y-3">
                    @foreach($this->inProgressTasks as $task)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3">
                            <a href="{{ route('tasks.show', $task) }}" wire:navigate class="text-sm font-medium text-gray-900 hover:text-indigo-600">{{ $task->title }}</a>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs px-2 py-0.5 rounded-full {{ $task->priority === 'urgent' ? 'bg-red-100 text-red-700' : ($task->priority === 'high' ? 'bg-orange-100 text-orange-700' : ($task->priority === 'medium' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700')) }}">{{ ucfirst($task->priority) }}</span>
                                <select wire:change="updateTaskStatus({{ $task->id }}, $event.target.value)" class="text-xs border-gray-200 rounded">
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

            <!-- Review -->
            <div class="bg-yellow-50 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-yellow-700 uppercase tracking-wider mb-4">Review ({{ $this->reviewTasks->count() }})</h3>
                <div class="space-y-3">
                    @foreach($this->reviewTasks as $task)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3">
                            <a href="{{ route('tasks.show', $task) }}" wire:navigate class="text-sm font-medium text-gray-900 hover:text-indigo-600">{{ $task->title }}</a>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs px-2 py-0.5 rounded-full {{ $task->priority === 'urgent' ? 'bg-red-100 text-red-700' : ($task->priority === 'high' ? 'bg-orange-100 text-orange-700' : ($task->priority === 'medium' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700')) }}">{{ ucfirst($task->priority) }}</span>
                                <select wire:change="updateTaskStatus({{ $task->id }}, $event.target.value)" class="text-xs border-gray-200 rounded">
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

            <!-- Done -->
            <div class="bg-green-50 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-green-700 uppercase tracking-wider mb-4">Done ({{ $this->doneTasks->count() }})</h3>
                <div class="space-y-3">
                    @foreach($this->doneTasks as $task)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3">
                            <a href="{{ route('tasks.show', $task) }}" wire:navigate class="text-sm font-medium text-gray-900 hover:text-indigo-600">{{ $task->title }}</a>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">Done</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
