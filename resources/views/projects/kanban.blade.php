<x-app-layout>
    <div class="mb-4 px-6 pt-6">
        <div class="flex justify-between items-center">
            <div>
                <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:text-blue-800">← Back to List View</a>
                <h2 class="text-2xl font-bold text-gray-900 mt-2">{{ $project->name }} - Kanban Board</h2>
            </div>
        </div>
    </div>

    @livewire('kanban-board', ['projectId' => $project->id])
</x-app-layout>