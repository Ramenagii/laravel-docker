<div class="py-8 px-4 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
                <p class="text-sm text-slate-500 mt-1">Welcome back, <span class="font-semibold text-slate-700">{{ auth()->user()->name }}</span>. Here's what's happening.</p>
            </div>
            <div class="mt-3 sm:mt-0 flex items-center space-x-2 text-xs text-slate-400">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Last updated {{ now()->diffForHumans() }}</span>
            </div>
        </div>

        <!-- Stat Cards with counter animation -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5 mb-8">
            <div x-data="{ count: 0, target: {{ $totalProjects }} }" x-init="let i = setInterval(() => { if (count < target) count++; else clearInterval(i) }, 30)"
                 class="group bg-white rounded-2xl shadow-sm border border-slate-200 p-5 md:p-6 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs md:text-sm font-medium text-slate-500">Total Projects</p>
                        <p class="text-2xl md:text-3xl font-bold text-slate-900 mt-1"><span x-text="count">0</span></p>
                    </div>
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-emerald-600 font-medium">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    <span>All active projects</span>
                </div>
            </div>

            <div x-data="{ count: 0, target: {{ array_sum($tasksByStatus) ?: 0 }} }" x-init="let i = setInterval(() => { if (count < target) count++; else clearInterval(i) }, 20)"
                 class="group bg-white rounded-2xl shadow-sm border border-slate-200 p-5 md:p-6 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs md:text-sm font-medium text-slate-500">Total Tasks</p>
                        <p class="text-2xl md:text-3xl font-bold text-slate-900 mt-1"><span x-text="count">0</span></p>
                    </div>
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-slate-500 font-medium">
                    <span>Across all projects</span>
                </div>
            </div>

            <div x-data="{ count: 0, target: {{ $myTasks }} }" x-init="let i = setInterval(() => { if (count < target) count++; else clearInterval(i) }, 30)"
                 class="group bg-white rounded-2xl shadow-sm border border-slate-200 p-5 md:p-6 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs md:text-sm font-medium text-slate-500">My Tasks</p>
                        <p class="text-2xl md:text-3xl font-bold text-slate-900 mt-1"><span x-text="count">0</span></p>
                    </div>
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg shadow-amber-200 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-slate-500 font-medium">
                    <span>Assigned to you</span>
                </div>
            </div>

            <div x-data="{ count: 0, target: {{ $myPendingTasks }} }" x-init="let i = setInterval(() => { if (count < target) count++; else clearInterval(i) }, 30)"
                 class="group bg-white rounded-2xl shadow-sm border border-slate-200 p-5 md:p-6 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs md:text-sm font-medium text-slate-500">Pending Tasks</p>
                        <p class="text-2xl md:text-3xl font-bold text-slate-900 mt-1"><span x-text="count">0</span></p>
                    </div>
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl flex items-center justify-center shadow-lg shadow-rose-200 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-rose-600 font-medium">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01" />
                    </svg>
                    <span>Needs attention</span>
                </div>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Tasks by Status -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h2 class="text-lg font-semibold text-slate-900 mb-5">Tasks by Status</h2>
                <div class="space-y-4">
                    @php
                        $total = array_sum($tasksByStatus) ?: 1;
                        $statusColors = [
                            'todo' => ['bg' => 'bg-slate-100', 'bar' => 'bg-slate-500', 'text' => 'text-slate-700'],
                            'in_progress' => ['bg' => 'bg-blue-100', 'bar' => 'bg-blue-600', 'text' => 'text-blue-700'],
                            'review' => ['bg' => 'bg-amber-100', 'bar' => 'bg-amber-500', 'text' => 'text-amber-700'],
                            'done' => ['bg' => 'bg-emerald-100', 'bar' => 'bg-emerald-500', 'text' => 'text-emerald-700'],
                            'cancelled' => ['bg' => 'bg-rose-100', 'bar' => 'bg-rose-500', 'text' => 'text-rose-700'],
                        ];
                    @endphp
                    @foreach(['todo' => 'Todo', 'in_progress' => 'In Progress', 'review' => 'Review', 'done' => 'Done', 'cancelled' => 'Cancelled'] as $key => $label)
                        @php $color = $statusColors[$key]; @endphp
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-sm font-medium text-slate-700">{{ $label }}</span>
                                <span class="text-sm font-semibold text-slate-900">{{ $tasksByStatus[$key] ?? 0 }}</span>
                            </div>
                            <div class="w-full {{ $color['bg'] }} rounded-full h-2">
                                <div class="{{ $color['bar'] }} h-2 rounded-full transition-all duration-500" style="width: {{ (($tasksByStatus[$key] ?? 0) / $total) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h2 class="text-lg font-semibold text-slate-900 mb-5">Recent Activity</h2>
                <div class="space-y-0">
                    @forelse($recentActivity as $activity)
                        <div class="flex items-start space-x-3 py-3 {{ !$loop->last ? 'border-b border-slate-100' : '' }}">
                            <div class="relative flex-shrink-0">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold
                                    {{ $activity->event === 'created' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ $activity->event === 'updated' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $activity->event === 'deleted' ? 'bg-rose-100 text-rose-700' : '' }}
                                    {{ !in_array($activity->event, ['created', 'updated', 'deleted']) ? 'bg-slate-100 text-slate-700' : '' }}">
                                    {{ substr($activity->causer?->name ?? 'S', 0, 2) }}
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-slate-900">
                                    <span class="font-semibold">{{ $activity->causer?->name ?? 'System' }}</span>
                                    <span class="text-slate-500">{{ $activity->description }}</span>
                                </p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                {{ $activity->event === 'created' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                {{ $activity->event === 'updated' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $activity->event === 'deleted' ? 'bg-rose-100 text-rose-700' : '' }}
                                {{ !in_array($activity->event, ['created', 'updated', 'deleted']) ? 'bg-slate-100 text-slate-600' : '' }}">
                                {{ $activity->event ?? 'action' }}
                            </span>
                        </div>
                    @empty
                        <div class="py-8 text-center">
                            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-slate-500">No recent activity.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
