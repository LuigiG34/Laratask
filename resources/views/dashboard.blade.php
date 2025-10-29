<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if ($workspace)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="mb-6">
                        <h2 class="text-3xl font-bold text-gray-900">{{ $workspace->name }}</h2>
                        <p class="text-gray-600 mt-1">{{ $workspace->projects()->count() }} projects</p>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <p class="text-gray-600 mb-4">Welcome to your workspace!</p>
                        <a href="{{ route('projects.index') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            View Projects
                        </a>
                    </div>
                </div>

                <!-- Activity Feed -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                        
                        <div class="space-y-4">
                            @forelse ($workspace->activities()->limit(10)->get() as $activity)
                                <div class="flex gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            @if ($activity->type === 'task_created')
                                                <span class="text-blue-600">➕</span>
                                            @elseif ($activity->type === 'task_status_changed')
                                                <span class="text-green-600">✓</span>
                                            @elseif ($activity->type === 'comment_added')
                                                <span class="text-purple-600">💬</span>
                                            @else
                                                <span class="text-gray-600">•</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-900">{{ $activity->description }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm">No activity yet</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-600 mb-4">No workspace selected</p>
                <a href="{{ route('workspaces.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Choose Workspace
                </a>
            </div>
        @endif
    </div>
</x-app-layout>