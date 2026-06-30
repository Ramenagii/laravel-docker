<div class="py-8 px-4 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Projects</h1>
                <p class="text-sm text-slate-500 mt-1">Manage and track all your projects</p>
            </div>
            <button wire:click="$set('showCreateModal', true)"
                    class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-150 shadow-sm shadow-indigo-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Project
            </button>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1 relative">
                    <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" wire:model.live.debounce="search" placeholder="Search projects..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-sm transition-colors">
                </div>
                <div class="flex space-x-2">
                    <button wire:click="$set('statusFilter', '')"
                            class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-150 {{ $statusFilter === '' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        All
                    </button>
                    <button wire:click="$set('statusFilter', 'active')"
                            class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-150 {{ $statusFilter === 'active' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Active
                    </button>
                    <button wire:click="$set('statusFilter', 'completed')"
                            class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-150 {{ $statusFilter === 'completed' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Completed
                    </button>
                    <button wire:click="$set('statusFilter', 'archived')"
                            class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-150 {{ $statusFilter === 'archived' ? 'bg-slate-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Archived
                    </button>
                </div>
            </div>
        </div>

        <!-- Project Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($this->projects as $project)
                <a href="{{ route('projects.show', $project) }}" wire:navigate
                   class="group bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-lg hover:border-indigo-200 transition-all duration-200">
                    <div class="p-5">
                        <div class="flex items-start justify-between mb-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center flex-shrink-0 shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium
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
                        <h3 class="text-base font-semibold text-slate-900 group-hover:text-indigo-600 transition-colors mb-1">{{ $project->name }}</h3>
                        <p class="text-sm text-slate-500 line-clamp-2">{{ Str::limit($project->description, 80) }}</p>
                        <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center text-sm text-slate-500">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <span>{{ $project->tasks_count }} {{ Str::plural('task', $project->tasks_count) }}</span>
                            </div>
                            <svg class="w-5 h-5 text-slate-300 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    <p class="text-slate-500 text-sm mb-4">No projects found.</p>
                    <button wire:click="$set('showCreateModal', true)" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create your first project
                    </button>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($this->projects->hasPages())
            <div class="mt-6 bg-white rounded-2xl shadow-sm border border-slate-200 px-6 py-4">
                {{ $this->projects->links() }}
            </div>
        @endif

        <!-- Create Project Modal -->
        @if($showCreateModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" wire:click="$set('showCreateModal', false)"></div>
                <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-auto overflow-hidden">
                    <!-- Modal Header -->
                    <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 bg-indigo-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-slate-900">Create Project</h3>
                        </div>
                        <button wire:click="$set('showCreateModal', false)" class="text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form wire:submit="create" class="px-6 py-5">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Project Name</label>
                            <input type="text" wire:model="name" placeholder="Enter project name..." class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error('name') <p class="text-red-500 text-xs mt-1.5 flex items-center"><svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
                            <textarea wire:model="description" rows="3" placeholder="Describe the project..." class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm resize-none"></textarea>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" wire:click="$set('showCreateModal', false)" class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-colors shadow-sm">
                                <span wire:loading.remove wire:target="create">Create Project</span>
                                <span wire:loading wire:target="create" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Creating...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
