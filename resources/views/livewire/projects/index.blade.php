<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Projects</h1>
            <button wire:click="$set('showCreateModal', true)" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                New Project
            </button>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" wire:model.live.debounce="search" placeholder="Search projects..." class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div>
                        <select wire:model.live="statusFilter" class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="divide-y divide-gray-200">
                @forelse($this->projects as $project)
                    <a href="{{ route('projects.show', $project) }}" wire:navigate class="block px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">{{ $project->name }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ Str::limit($project->description, 100) }}</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-gray-500">{{ $project->tasks_count }} tasks</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $project->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $project->status === 'inactive' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $project->status === 'archived' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="px-6 py-12 text-center">
                        <p class="text-gray-500">No projects found.</p>
                    </div>
                @endforelse
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $this->projects->links() }}
            </div>
        </div>

        @if($showCreateModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center">
                <div class="fixed inset-0 bg-black opacity-50" wire:click="$set('showCreateModal', false)"></div>
                <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full mx-4">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Create Project</h3>
                    </div>
                    <form wire:submit="create" class="px-6 py-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" wire:model="name" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea wire:model="description" rows="3" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" wire:click="$set('showCreateModal', false)" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
