<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">My Tasks</h2>
            <p class="text-gray-600 mt-1">Tasks assigned to you across all workspaces</p>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <form method="GET" class="flex flex-col sm:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $search }}"
                        placeholder="Search tasks..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                    >
                </div>

                <!-- Status Filter -->
                <div>
                    <select 
                        name="status"
                        onchange="this.form.submit()"
                        class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                    >
                        <option value="">All Status</option>
                        <option value="todo" {{ $status === 'todo' ? 'selected' : '' }}>To Do</option>
                        <option value="in_progress" {{ $status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="done" {{ $status === 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                </div>

                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">
                    Search
                </button>
            </form>
        </div>

        <!-- Tasks List -->
        <div class="bg-white rounded-lg shadow divide-y divide-gray-200">
            @forelse ($tasks as $task)
                <div class="p-4 hover:bg-gray-50 transition">
                    <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                        <!-- Task Info -->
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('tasks.show', $task) }}" class="block group">
                                <h3 class="font-medium text-gray-900 group-hover:text-blue-600 {{ $task->status === 'done' ? 'line-through' : '' }}">
                                    {{ $task->title }}
                                </h3>
                                @if ($task->description)
                                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($task->description, 100) }}</p>
                                @endif
                            </a>

                            <div class="flex flex-wrap items-center gap-3 mt-2 text-sm">
                                <!-- Status Badge -->
                                <span class="px-2 py-1 rounded text-xs font-medium
                                    {{ $task->status === 'todo' ? 'bg-gray-200 text-gray-700' : '' }}
                                    {{ $task->status === 'in_progress' ? 'bg-blue-200 text-blue-700' : '' }}
                                    {{ $task->status === 'done' ? 'bg-green-200 text-green-700' : '' }}
                                ">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>

                                <!-- Project -->
                                <span class="text-gray-600">
                                    📁 {{ $task->project->name }}
                                </span>

                                <!-- Due Date -->
                                @if ($task->due_date)
                                    <span class="text-gray-600 {{ $task->due_date->isPast() && $task->status !== 'done' ? 'text-red-600 font-medium' : '' }}">
                                        📅 {{ $task->due_date->format('M d, Y') }}
                                        @if ($task->due_date->isPast() && $task->status !== 'done')
                                            (Overdue)
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">📋</div>
                    <p class="text-gray-600 mb-2">No tasks assigned to you</p>
                    <p class="text-sm text-gray-500">Tasks assigned to you will appear here</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($tasks->hasPages())
            <div class="mt-6">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>
</x-app-layout>