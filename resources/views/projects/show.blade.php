<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('projects.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Projects</a>
        </div>

        <div class="mb-6">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-4 h-4 rounded-full" style="background-color: {{ $project->color }}"></div>
                        <h2 class="text-3xl font-bold text-gray-900">{{ $project->name }}</h2>
                    </div>
                    <p class="text-gray-600">{{ $project->description }}</p>
                </div>
                <a href="{{ route('projects.edit', $project) }}" class="px-4 py-2 bg-gray-200 text-gray-900 rounded hover:bg-gray-300">
                    Edit Project
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tasks section (placeholder for now) -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Tasks</h3>
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Add Task
                </button>
            </div>

            @if ($project->tasks->isEmpty())
                <div class="text-center py-8 text-gray-500">
                    <p>No tasks yet. Create your first task to get started!</p>
                </div>
            @else
                <div class="space-y-2">
                    @foreach ($project->tasks as $task)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded hover:bg-gray-100">
                            <input type="checkbox" {{ $task->status === 'done' ? 'checked' : '' }} class="rounded">
                            <span class="flex-1 {{ $task->status === 'done' ? 'line-through text-gray-500' : 'text-gray-900' }}">
                                {{ $task->title }}
                            </span>
                            @if ($task->assignee)
                                <span class="text-sm text-gray-600">{{ $task->assignee->name }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>