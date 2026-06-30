<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Activity Log</h1>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 border-b border-gray-200">
                <input type="text" wire:model.live.debounce="search" placeholder="Search activity..." class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            </div>

            <div class="divide-y divide-gray-200">
                @forelse($activities as $activity)
                    <div class="px-6 py-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-medium text-gray-600">{{ substr($activity->causer?->name ?? 'S', 0, 2) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900">
                                    <span class="font-medium">{{ $activity->causer?->name ?? 'System' }}</span>
                                    {{ $activity->description }}
                                </p>
                                @if($activity->properties->count())
                                    <div class="mt-1 bg-gray-50 rounded p-2 text-xs text-gray-600 font-mono">
                                        @foreach($activity->properties->get('attributes', []) as $key => $value)
                                            @if($key !== 'updated_at')
                                                <span>{{ $key }}: {{ is_string($value) ? $value : json_encode($value) }}</span>@if(!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="text-xs text-gray-500">{{ $activity->created_at->format('M j, Y g:i A') }}</span>
                                    <span class="text-xs text-gray-400">&middot;</span>
                                    <span class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <p class="text-gray-500">No activity found.</p>
                    </div>
                @endforelse
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</div>
