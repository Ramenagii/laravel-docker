<div class="py-8 px-4 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-900">Users</h1>
            <p class="text-sm text-slate-500 mt-1">Manage user accounts and roles</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <!-- Search -->
            <div class="p-4 border-b border-slate-200">
                <div class="relative">
                    <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" wire:model.live.debounce="search" placeholder="Search users by name or email..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-sm transition-colors">
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($users as $i => $user)
                            <tr x-data="{ show: false }" x-init="setTimeout(() => show = true, {{ $i }} * 30)" x-show="show" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
                                class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm shadow-sm flex-shrink-0">
                                            {{ substr($user->name, 0, 1) }}
                                        </span>
                                        <div class="ml-3">
                                            <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-slate-500">{{ $user->email }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($editingRole === $user->id)
                                        <div class="flex items-center space-x-2">
                                            <select wire:model="selectedRole" class="text-sm border-slate-200 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 py-1.5">
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                                @endforeach
                                            </select>
                                            <button wire:click="saveRole" wire:loading.attr="disabled" wire:target="saveRole" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed inline-flex items-center">
                                                <span wire:loading.remove wire:target="saveRole">Save</span>
                                                <span wire:loading wire:target="saveRole" class="flex items-center">
                                                    <svg class="animate-spin w-3.5 h-3.5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    Saving...
                                                </span>
                                            </button>
                                            <button wire:click="cancelEdit" class="text-slate-400 hover:text-slate-600 text-sm transition-colors">Cancel</button>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium 
                                            @if($user->roles->first()?->name === 'admin') bg-indigo-100 text-indigo-700 
                                            @elseif($user->roles->first()?->name === 'manager') bg-emerald-100 text-emerald-700
                                            @else bg-slate-100 text-slate-600 @endif">
                                            @if($user->roles->first()?->name === 'admin')
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                            @endif
                                            {{ $user->roles->first()?->name ?? 'No role' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    @if($editingRole !== $user->id)
                                        <button wire:click="editRole({{ $user->id }})" wire:loading.attr="disabled" wire:target="editRole({{ $user->id }})" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                            <span wire:loading.remove wire:target="editRole({{ $user->id }})">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit Role
                                            </span>
                                            <span wire:loading wire:target="editRole({{ $user->id }})" class="flex items-center">
                                                <svg class="animate-spin w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
