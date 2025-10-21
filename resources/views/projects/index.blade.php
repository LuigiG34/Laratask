<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">{{ $workspace->name }}</h2>
                <p class="text-gray-600 mt-1">{{ $projects->count() }} projects</p>
            </div>
            <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">
                + New Project
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 px-4 py-3 bg-red-100 border border-red-300 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($projects as $project)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                    <div class="h-2" style="background-color: {{ $project->color }}"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            <a href="{{ route('projects.show', $project) }}" class="hover:text-blue-600">
                                {{ $project->name }}
                            </a>
                        </h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ $project->description ?? 'No description' }}
                        </p>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">
                                {{ $project->tasks_count }} tasks
                            </span>
                            <div class="flex gap-2">
                                <a href="{{ route('projects.edit', $project) }}" class="text-blue-600 hover:text-blue-800">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Are you sure?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 bg-white rounded-lg shadow">
                    <p class="text-gray-600 mb-4">No projects yet</p>
                    <a href="{{ route('projects.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Create Your First Project
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>