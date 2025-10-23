<x-app-layout>
    <div class="max-w-2xl mx-auto py-12 px-4">
        <div class="mb-6">
            <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:text-blue-800">← Back to Task</a>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Task</h2>

        <form method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-6 bg-white rounded-lg shadow p-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 font-medium mb-2">Task Title *</label>
                <input 
                    type="text" 
                    name="title" 
                    value="{{ old('title', $task->title) }}"
                    required 
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                >
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea 
                    name="description" 
                    rows="5" 
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                >{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Status *</label>
                <select 
                    name="status" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                >
                    <option value="todo" {{ old('status', $task->status) === 'todo' ? 'selected' : '' }}>To Do</option>
                    <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="done" {{ old('status', $task->status) === 'done' ? 'selected' : '' }}>Done</option>
                </select>
                @error('status')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Due Date</label>
                <input 
                    type="date" 
                    name="due_date" 
                    value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                >
                @error('due_date')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Assign To</label>
                <select 
                    name="assigned_to"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                >
                    <option value="">Unassigned</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}" {{ old('assigned_to', $task->assigned_to) == $member->id ? 'selected' : '' }}>
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
                @error('assigned_to')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">
                    Save Changes
                </button>
                <a href="{{ route('tasks.show', $task) }}" class="px-4 py-2 bg-gray-200 text-gray-900 rounded hover:bg-gray-300 font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>