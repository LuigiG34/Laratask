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

        <!-- Filter Tabs -->
        <div class="mb-4 border-b border-gray-200">
            <div class="flex gap-4">
                <a href="{{ route('projects.show', $project) }}" 
                   class="px-4 py-2 {{ !request('status') ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                    All ({{ $project->tasks->count() }})
                </a>
                <a href="{{ route('projects.show', $project) }}?status=todo" 
                   class="px-4 py-2 {{ request('status') === 'todo' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                    To Do ({{ $project->tasks->where('status', 'todo')->count() }})
                </a>
                <a href="{{ route('projects.show', $project) }}?status=in_progress" 
                   class="px-4 py-2 {{ request('status') === 'in_progress' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                    In Progress ({{ $project->tasks->where('status', 'in_progress')->count() }})
                </a>
                <a href="{{ route('projects.show', $project) }}?status=done" 
                   class="px-4 py-2 {{ request('status') === 'done' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                    Done ({{ $project->tasks->where('status', 'done')->count() }})
                </a>
            </div>
        </div>

        <!-- Quick Add Task Form -->
        <div class="mb-6 bg-white rounded-lg shadow p-4">
            <form method="POST" action="{{ route('tasks.store') }}" class="flex gap-3">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <input type="hidden" name="status" value="todo">
                
                <input 
                    type="text" 
                    name="title" 
                    placeholder="Add a new task..." 
                    required
                    class="flex-1 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                >
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">
                    Add Task
                </button>
            </form>
        </div>

        <!-- Tasks List -->
        <div class="bg-white rounded-lg shadow">
            @php
                $filteredTasks = request('status') 
                    ? $project->tasks->where('status', request('status'))
                    : $project->tasks;
            @endphp

            @if ($filteredTasks->isEmpty())
                <div class="text-center py-12 text-gray-500">
                    <p>No tasks yet. Create your first task to get started!</p>
                </div>
            @else
                <div class="divide-y divide-gray-200">
                    @foreach ($filteredTasks as $task)
                        <div class="p-4 hover:bg-gray-50 transition">
                            <div class="flex items-start gap-4">
                                <!-- Status Checkbox -->
                                <form method="POST" action="{{ route('tasks.updateStatus', $task) }}" class="pt-1">
                                    @csrf
                                    @method('PATCH')
                                    <input 
                                        type="checkbox" 
                                        {{ $task->status === 'done' ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="w-5 h-5 text-blue-600 rounded cursor-pointer"
                                    >
                                    <input type="hidden" name="status" value="{{ $task->status === 'done' ? 'todo' : 'done' }}">
                                </form>

                                <!-- Task Info -->
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('tasks.show', $task) }}" class="block group">
                                        <h3 class="font-medium {{ $task->status === 'done' ? 'line-through text-gray-500' : 'text-gray-900' }} group-hover:text-blue-600">
                                            {{ $task->title }}
                                        </h3>
                                        @if ($task->description)
                                            <p class="text-sm text-gray-600 mt-1 line-clamp-1">{{ $task->description }}</p>
                                        @endif
                                    </a>

                                    <div class="flex items-center gap-4 mt-2 text-sm">
                                        <!-- Status Badge -->
                                        <span class="px-2 py-1 rounded text-xs font-medium
                                            {{ $task->status === 'todo' ? 'bg-gray-200 text-gray-700' : '' }}
                                            {{ $task->status === 'in_progress' ? 'bg-blue-200 text-blue-700' : '' }}
                                            {{ $task->status === 'done' ? 'bg-green-200 text-green-700' : '' }}
                                        ">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>

                                        <!-- Due Date -->
                                        @if ($task->due_date)
                                            <span class="text-gray-600 flex items-center gap-1">
                                                📅 {{ $task->due_date->format('M d, Y') }}
                                                @if ($task->due_date->isPast() && $task->status !== 'done')
                                                    <span class="text-red-600 font-medium">(Overdue)</span>
                                                @endif
                                            </span>
                                        @endif

                                        <!-- Assignee -->
                                        @if ($task->assignee)
                                            <span class="text-gray-600 flex items-center gap-1">
                                                👤 {{ $task->assignee->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-2">
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>