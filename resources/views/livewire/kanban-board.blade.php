<div class="bg-gray-50 min-h-screen p-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- TO DO Column -->
        <div class="bg-gray-100 rounded-lg p-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-gray-700 uppercase text-sm">To Do ({{ $todoTasks->count() }})</h3>
                <button 
                    @click="$wire.newTaskColumn = 'todo'; $wire.newTaskTitle = ''; $refs.addTaskModal.classList.remove('hidden')"
                    class="text-gray-600 hover:text-gray-900"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </button>
            </div>

            <div class="space-y-3 kanban-column min-h-[200px]" data-status="todo">
                @foreach ($todoTasks as $task)
                    <div class="kanban-card bg-white rounded shadow p-4 cursor-move" data-task-id="{{ $task->id }}">
                        <a href="{{ route('tasks.show', $task) }}" class="block hover:text-blue-600">
                            <h4 class="font-medium text-gray-900 mb-2">{{ $task->title }}</h4>
                        </a>
                        
                        @if ($task->description)
                            <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ Str::limit($task->description, 80) }}</p>
                        @endif

                        <div class="flex items-center justify-between text-xs text-gray-500">
                            @if ($task->due_date)
                                <span class="{{ $task->due_date->isPast() ? 'text-red-600 font-medium' : '' }}">
                                    📅 {{ $task->due_date->format('M d') }}
                                </span>
                            @else
                                <span></span>
                            @endif

                            @if ($task->assignee)
                                <span class="font-medium">{{ $task->assignee->name }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- IN PROGRESS Column -->
        <div class="bg-blue-50 rounded-lg p-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-blue-700 uppercase text-sm">In Progress ({{ $inProgressTasks->count() }})</h3>
                <button 
                    @click="$wire.newTaskColumn = 'in_progress'; $wire.newTaskTitle = ''; $refs.addTaskModal.classList.remove('hidden')"
                    class="text-blue-600 hover:text-blue-900"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </button>
            </div>

            <div class="space-y-3 kanban-column min-h-[200px]" data-status="in_progress">
                @foreach ($inProgressTasks as $task)
                    <div class="kanban-card bg-white rounded shadow p-4 cursor-move" data-task-id="{{ $task->id }}">
                        <a href="{{ route('tasks.show', $task) }}" class="block hover:text-blue-600">
                            <h4 class="font-medium text-gray-900 mb-2">{{ $task->title }}</h4>
                        </a>
                        
                        @if ($task->description)
                            <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ Str::limit($task->description, 80) }}</p>
                        @endif

                        <div class="flex items-center justify-between text-xs text-gray-500">
                            @if ($task->due_date)
                                <span class="{{ $task->due_date->isPast() ? 'text-red-600 font-medium' : '' }}">
                                    📅 {{ $task->due_date->format('M d') }}
                                </span>
                            @else
                                <span></span>
                            @endif

                            @if ($task->assignee)
                                <span class="font-medium">{{ $task->assignee->name }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- DONE Column -->
        <div class="bg-green-50 rounded-lg p-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-green-700 uppercase text-sm">Done ({{ $doneTasks->count() }})</h3>
                <button 
                    @click="$wire.newTaskColumn = 'done'; $wire.newTaskTitle = ''; $refs.addTaskModal.classList.remove('hidden')"
                    class="text-green-600 hover:text-green-900"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </button>
            </div>

            <div class="space-y-3 kanban-column min-h-[200px]" data-status="done">
                @foreach ($doneTasks as $task)
                    <div class="kanban-card bg-white rounded shadow p-4 cursor-move opacity-75" data-task-id="{{ $task->id }}">
                        <a href="{{ route('tasks.show', $task) }}" class="block hover:text-blue-600">
                            <h4 class="font-medium text-gray-900 mb-2 line-through">{{ $task->title }}</h4>
                        </a>
                        
                        @if ($task->description)
                            <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ Str::limit($task->description, 80) }}</p>
                        @endif

                        <div class="flex items-center justify-between text-xs text-gray-500">
                            @if ($task->due_date)
                                <span>📅 {{ $task->due_date->format('M d') }}</span>
                            @else
                                <span></span>
                            @endif

                            @if ($task->assignee)
                                <span class="font-medium">{{ $task->assignee->name }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div x-ref="addTaskModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" @click.self="$refs.addTaskModal.classList.add('hidden')">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Add Task</h3>
            
            <form wire:submit.prevent="addTask">
                <div class="mb-4">
                    <input 
                        type="text" 
                        wire:model="newTaskTitle"
                        placeholder="Task title..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                        autofocus
                    >
                    @error('newTaskTitle') 
                        <span class="text-red-600 text-sm">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button 
                        type="submit" 
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    >
                        Add Task
                    </button>
                    <button 
                        type="button"
                        @click="$refs.addTaskModal.classList.add('hidden')"
                        class="px-4 py-2 bg-gray-200 text-gray-900 rounded hover:bg-gray-300"
                    >
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@script
<script>
    document.addEventListener('livewire:navigated', function() {
        initKanban();
    });

    // Also run on initial load
    initKanban();

    function initKanban() {
        const columns = document.querySelectorAll('.kanban-column');
        
        columns.forEach(column => {
            new Sortable(column, {
                group: 'kanban',
                animation: 150,
                ghostClass: 'opacity-50',
                onEnd: function(evt) {
                    const taskId = evt.item.dataset.taskId;
                    const newStatus = evt.to.dataset.status;
                    const newPosition = evt.newIndex;
                    
                    // Call Livewire method to update task
                    $wire.updateTaskOrder(taskId, newStatus, newPosition);
                }
            });
        });
    }
</script>
@endscript