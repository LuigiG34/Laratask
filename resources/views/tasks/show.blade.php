<x-app-layout>
    <div class="max-w-4xl mx-auto py-6 px-4">
        <div class="mb-6">
            <a href="{{ route('projects.show', $task->project) }}" class="text-blue-600 hover:text-blue-800">
                ← Back to {{ $task->project->name }}
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <!-- Task Header -->
            <div class="flex items-start justify-between mb-6">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $task->title }}</h1>
                    <div class="flex items-center gap-4 text-sm">
                        <span class="px-2 py-1 rounded text-xs font-medium
                            {{ $task->status === 'todo' ? 'bg-gray-200 text-gray-700' : '' }}
                            {{ $task->status === 'in_progress' ? 'bg-blue-200 text-blue-700' : '' }}
                            {{ $task->status === 'done' ? 'bg-green-200 text-green-700' : '' }}
                        ">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                        <span class="text-gray-600">in {{ $task->project->name }}</span>
                    </div>
                </div>
                <a href="{{ route('tasks.edit', $task) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Edit
                </a>
            </div>

            <!-- Task Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Assigned To</label>
                    <div class="text-gray-900">
                        {{ $task->assignee ? $task->assignee->name : 'Unassigned' }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                    <div class="text-gray-900">
                        {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}
                        @if ($task->due_date && $task->due_date->isPast() && $task->status !== 'done')
                            <span class="text-red-600 font-medium ml-2">(Overdue)</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <div class="text-gray-900 whitespace-pre-wrap">
                    {{ $task->description ?: 'No description provided.' }}
                </div>
            </div>

            <!-- Comments Section -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Comments</h3>
                @livewire('task-comments', ['taskId' => $task->id])
            </div>
        </div>
    </div>
</x-app-layout>