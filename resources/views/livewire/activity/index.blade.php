<div class="py-8 px-4 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-900">Activity Log</h1>
            <p class="text-sm text-slate-500 mt-1">Track all changes and actions across the system</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <!-- Search -->
            <div class="p-4 border-b border-slate-200">
                <div class="relative">
                    <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" wire:model.live.debounce="search" placeholder="Search activity..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-sm transition-colors">
                </div>
            </div>

            <!-- Activity List (Timeline) with staggered animation -->
            <div class="relative">
                <div class="absolute left-8 top-0 bottom-0 w-px bg-slate-200"></div>
                <div>
                    @forelse($activities as $i => $activity)
                        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, {{ $i }} * 30)" x-show="show" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
                             class="relative px-6 py-5 hover:bg-slate-50/50 transition-colors">
                            <div class="flex items-start space-x-4">
                                <!-- Timeline Dot -->
                                <div class="relative z-10 flex-shrink-0 mt-0.5 group-hover:scale-110 transition-transform">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center shadow-sm
                                        {{ $activity->event === 'created' ? 'bg-emerald-100 text-emerald-600 ring-4 ring-white' : '' }}
                                        {{ $activity->event === 'updated' ? 'bg-blue-100 text-blue-600 ring-4 ring-white' : '' }}
                                        {{ $activity->event === 'deleted' ? 'bg-red-100 text-red-600 ring-4 ring-white' : '' }}
                                        {{ !in_array($activity->event, ['created', 'updated', 'deleted']) ? 'bg-slate-100 text-slate-500 ring-4 ring-white' : '' }}">
                                        @if($activity->event === 'created')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        @elseif($activity->event === 'updated')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        @elseif($activity->event === 'deleted')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                        <p class="text-sm text-slate-900">
                                            <span class="font-semibold">{{ $activity->causer?->name ?? 'System' }}</span>
                                            <span class="text-slate-500"> {{ $activity->description }}</span>
                                        </p>
                                        <span class="text-xs px-2 py-0.5 rounded-full font-medium sm:ml-2 flex-shrink-0 self-start
                                            {{ $activity->event === 'created' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                            {{ $activity->event === 'updated' ? 'bg-blue-100 text-blue-700' : '' }}
                                            {{ $activity->event === 'deleted' ? 'bg-red-100 text-red-700' : '' }}
                                            {{ !in_array($activity->event, ['created', 'updated', 'deleted']) ? 'bg-slate-100 text-slate-600' : '' }}">
                                            {{ $activity->event ?? 'action' }}
                                        </span>
                                    </div>

                                    @if($activity->properties->count())
                                        <div class="mt-2 bg-slate-50 rounded-xl p-3 border border-slate-200">
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($activity->properties->get('attributes', []) as $key => $value)
                                                    @if($key !== 'updated_at')
                                                        <span class="text-xs">
                                                            <span class="font-medium text-slate-600">{{ $key }}:</span>
                                                            <span class="text-slate-500 font-mono">{{ is_string($value) ? $value : json_encode($value) }}</span>
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="flex flex-wrap items-center gap-x-2 mt-1.5">
                                        <span class="text-xs text-slate-400">{{ $activity->created_at->format('M j, Y g:i A') }}</span>
                                        <span class="text-xs text-slate-300 hidden sm:inline">&middot;</span>
                                        <span class="text-xs text-slate-400">{{ $activity->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-16 text-center">
                            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-slate-500 text-sm">No activity found.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($activities->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $activities->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
